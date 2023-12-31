<script setup>
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    href: String,
    color: "red" | "blue" | "yellow" | "green" | "indigo",
});

let classes =
    "inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest focus:outline-none disabled:opacity-25 transition mr-1 ";

switch (props?.color) {
    case "red":
        classes +=
            "bg-red-800 hover:bg-red-700 active:bg-red-900 focus:border-red-900 focus:ring focus:ring-red-300 dark:bg-red-600";
        break;
    case "green":
        classes +=
            "bg-green-800 hover:bg-green-700 active:bg-green-900 focus:border-green-900 focus:ring focus:ring-green-300 dark:bg-green-600";
        break;
    case "blue":
        classes +=
            "bg-blue-800 hover:bg-blue-700 active:bg-blue-900 focus:border-blue-900 focus:ring focus:ring-blue-300 dark:bg-blue-600";
        break;
    case "yellow":
        classes +=
            "bg-yellow-800 hover:bg-yellow-700 active:bg-yellow-900 focus:border-yellow-900 focus:ring focus:ring-yellow-300 dark:bg-yellow-600";
        break;
    case "indigo":
        classes +=
            "bg-indigo-800 hover:bg-indigo-700 active:bg-indigo-900 focus:border-indigo-900 focus:ring focus:ring-indigo-300 dark:bg-indigo-600";
        break;
    default:
        classes +=
            "bg-gray-800 hover:bg-gray-700 active:bg-gray-900 focus:border-gray-900 focus:ring focus:ring-gray-300 dark:bg-gray-600";
}
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
