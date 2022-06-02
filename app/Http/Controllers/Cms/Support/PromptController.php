<?php

namespace App\Http\Controllers\Cms\Support;

use Exception;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Contracts\Support\Arrayable;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Output\Output;
use Symfony\Component\Console\Input\ArgvInput;

class PromptController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Cms/Support/Console');
    }

    public function exeCommand(Request $request)
    {
        ini_set('max_execution_time', 0);
        $command = $request->get('command', 'list');

        if (1 === Artisan::handle(
            new ArgvInput(explode(' ', 'artisan ' . trim($command))),
            $output = new StringOutput()
        )) {
            return $this->renderException(new Exception($output->getContent()));
        }

        return sprintf('<pre>%s</pre>', $output->getContent());
    }

    public function runDatabase(Request $request)
    {
        $query = $request->get('q');

        $connection = $request->get('c', config('database.default'));

        return $this->dispatchQuery($connection, $query);
    }

    protected function getDumpedHtml($var)
    {
        ob_start();

        dump($var);

        $content = ob_get_contents();

        ob_get_clean();

        return substr($content, strpos($content, '<pre '));
    }

    protected function connections()
    {
        $dbs = $redis = [];

        foreach (config('database.connections') as $name => $_) {
            $dbs[] = [
                'option' => $name,
                'value' => "db:$name",
                'selected' => $name == config('database.default'),
            ];
        }

        $connections = array_filter(config('database.redis'), function ($config) {
            return is_array($config);
        });

        foreach ($connections as $name => $_) {
            $redis[] = [
                'value' => "redis:$name",
                'option' => $name,
            ];
        }

        return compact('dbs', 'redis');
    }

    protected function table(array $headers, $rows, $style = 'default')
    {
        $output = new StringOutput();

        $table = new Table($output);

        if ($rows instanceof Arrayable) {
            $rows = $rows->toArray();
        }

        $table->setHeaders($headers)->setRows($rows)->setStyle($style)->render();

        return $output->getContent();
    }

    protected function dispatchQuery($connection, $query)
    {
        list($type, $connection) = explode(':', $connection);

        if ($type == 'redis') {
            return $this->execRedisCommand($connection, $query);
        }

        $config = config('database.connections.' . $connection);

        if ($config['driver'] == 'mongodb') {
            return $this->execMongodbQuery($config, $query);
        }

        /* @var \Illuminate\Database\Connection $connection */
        $connection = DB::connection($connection);

        $connection->enableQueryLog();

        try {
            $result = $connection->select(str_replace([';', "\G"], '', $query));
        } catch (Exception $exception) {
            return $this->renderException($exception);
        }

        $log = current($connection->getQueryLog());

        if (empty($result)) {
            return sprintf("<pre>Empty set (%s sec)</pre>\r\n", number_format($log['time'] / 1000, 2));
        }

        $result = json_decode(json_encode($result), true);

        if (Str::contains($query, "\G")) {
            return $this->getDumpedHtml($result);
        }

        return sprintf(
            "<pre>%s \n%d %s in set (%s sec)</pre>\r\n",
            $this->table(array_keys(current($result)), $result),
            count($result),
            count($result) == 1 ? 'row' : 'rows',
            number_format($log['time'] / 1000, 2)
        );
    }

    protected function execRedisCommand($connection, $command)
    {
        $command = explode(' ', $command);

        try {
            $result = Redis::connection($connection)->executeRaw($command);
        } catch (Exception $exception) {
            return $this->renderException($exception);
        }

        if (is_string($result) && Str::startsWith($result, ['ERR ', 'WRONGTYPE '])) {
            return $this->renderException(new Exception($result));
        }

        return $this->getDumpedHtml($result);
    }

    protected function organizedCommands()
    {
        $commands = array_keys(Artisan::all());

        $groups = $others = [];

        foreach ($commands as $command) {
            $parts = explode(':', $command);

            if (isset($parts[1])) {
                $groups[$parts[0]][] = $command;
            } else {
                $others[] = $command;
            }
        }

        foreach ($groups as $key => $group) {
            if (count($group) === 1) {
                $others[] = $group[0];

                unset($groups[$key]);
            }
        }

        ksort($groups);
        sort($others);

        return compact('groups', 'others');
    }

    protected function renderException(Exception $exception)
    {
        return sprintf(
            "<div class='callout callout-warning'><i class='icon fa fa-warning'></i>&nbsp;&nbsp;&nbsp;%s</div>",
            str_replace("\n", '<br />', $exception->getMessage())
        );
    }
}

class StringOutput extends Output
{
    public $output = '';

    public function clear()
    {
        $this->output = '';
    }

    protected function doWrite($message, $newline)
    {
        $this->output .= $message . ($newline ? "\n" : '');
    }

    public function getContent()
    {
        return trim($this->output);
    }
}
