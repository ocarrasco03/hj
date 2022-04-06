<script setup>
defineProps({
    srcset: Object,
    url: String,
});

const getSrcSet = (set) => {
    let srcsetCollection = '';
    set.urls.forEach((element, index) => {
        srcsetCollection += `${element} ${parseInt(width(element))}w`;
        if (index < (set.urls.length - 1)) {
            srcsetCollection += ', ';
        }
    });

    return srcsetCollection;
};

const width = (name) => {
    let propertyParts = getPropertyParts(name);
    propertyParts.pop();

    return propertyParts.slice(-1);
};

const getPropertyParts = (fileName) => {
    let propertyString = stringBetween(fileName, "___", ".");
    return propertyString.split("_");
};

const stringBetween = (subject, startCharacter, endCharacter) => {
    let lastPos = subject.lastIndexOf(startCharacter);
    let between = subject.substring(lastPos);
    between = between.replace("___", "");
    between = strstr(between, endCharacter, true);
    return between;
};

const strstr = (haystack, needle, bool = false) => {
    let pos = 0;

    haystack += "";
    pos = haystack.indexOf(needle);
    if (pos == -1) {
        return false;
    } else {
        if (bool) {
            return haystack.substr(0, pos);
        } else {
            return haystack.slice(pos);
        }
    }
};
</script>

<template>
    <img
        :srcset="getSrcSet(srcset)"
        :src="url"
    />
</template>
