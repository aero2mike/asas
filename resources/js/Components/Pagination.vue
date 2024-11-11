<script setup>
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    links: Array,
    pageName: {
        type: String,
        default: 'page'
    }
});

const url = (page, pageName) => {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    urlParams.set(pageName, page);
    return `${window.location.pathname}?${urlParams.toString()}`;
};
</script>

<template>
    <div v-if="links.length > 3" class="text-gray-600">
        <div class="flex justify-center flex-wrap -mb-1 text-gray-600">
            <template v-for="(link, key) in links">
                <div
                    v-if="link.url === null"
                    :key="key"
                    class="mb-1 mr-1 px-4 py-3 text-gray-400 text-sm leading-4 border rounded"
                    v-html="link.label"
                />
                
                <Link
                    :preserveScroll="true"
                    v-else
                    :key="`link-${key}`"
                    class="mb-1 mr-1 px-4 py-3 focus:text-indigo-500 text-sm leading-4 hover:bg-gray-300 text-gray-900 border focus:border-indigo-500 rounded"
                    :class="{ 'bg-gray-300': link.active }"
                    :href="url(link.label, pageName)"
                    v-html="link.label"
                />
            </template>
        </div>
    </div>
</template>