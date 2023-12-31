<script setup>
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    links: Array,
});
</script>
<template>
    <div class="flex justify-center" v-if="links?.length > 3">
        <div class="flex flex-wrap -mb-1">
            <template v-for="(link, key) in links">
                <div
                    v-if="link.url === null"
                    :key="key"
                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest focus:outline-none opacity-70 transition mr-1 bg-gray-700 focus:border-gray-900 focus:ring focus:ring-gray-300 dark:bg-gray-600 cursor-not-allowed"
                    v-html="link.label"
                />
                <Link
                    v-else
                    :key="`link-${key}`"
                    :class="
                        link.active
                            ? 'inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest focus:outline-none transition mr-1 bg-gray-600 hover:bg-gray-700 active:bg-gray-900 focus:border-gray-900 focus:ring focus:ring-gray-300 dark:bg-gray-500'
                            : 'inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest focus:outline-none transition mr-1 bg-gray-800 hover:bg-gray-700 active:bg-gray-900 focus:border-gray-900 focus:ring focus:ring-gray-300 dark:bg-gray-600'
                    "
                    :href="link.url"
                    v-html="link.label"
                />
            </template>
        </div>
    </div>
    <div v-else>&nbsp;</div>
</template>
