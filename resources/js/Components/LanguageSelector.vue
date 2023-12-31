<script setup>
import { usePage } from "@inertiajs/vue3";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";

const currentLocale = usePage().props.locale;

const switchLocale = async (lang) => {
    await axios.get(route("locale", lang));
    location.reload();
};
</script>
<template>
    <Dropdown align="right" width="80">
        <template #trigger>
            <span class="inline-flex rounded-md">
                <button
                    type="button"
                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none focus:bg-gray-50 dark:focus:bg-gray-700 active:bg-gray-50 dark:active:bg-gray-700 transition ease-in-out duration-150"
                >
                    {{ $t('lang.language') }}

                    <svg
                        class="ms-2 -me-0.5 h-4 w-4"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9"
                        />
                    </svg>
                </button>
            </span>
        </template>

        <template #content>
            <div class="w-60">
                <!-- Language -->
                <DropdownLink href="#" @click="switchLocale('pt-BR')">
                    <div v-if="currentLocale == 'pt_BR'" class="font-bold">
                        {{ $t("lang.portuguese_brazil") }}
                    </div>
                    <div v-else>{{ $t("lang.portuguese_brazil") }}</div>
                </DropdownLink>
                <DropdownLink href="#" @click="switchLocale('en')">
                    <div v-if="currentLocale == 'en'" class="font-bold">
                        {{ $t("lang.english") }}
                    </div>
                    <div v-else>{{ $t("lang.english") }}</div>
                </DropdownLink>
            </div>
        </template>
    </Dropdown>
</template>
