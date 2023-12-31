<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Link from "@/Components/Link.vue";
import Tooltip from "@/Components/Tooltip.vue";
import Pagination from "@/Components/Pagination.vue";
import DangerButton from "@/Components/DangerButton.vue";
import { getCurrentInstance } from "vue";
import { toast } from "vue3-toastify";

const instance = getCurrentInstance();

defineProps({
    can: Object,
    hotels: Object,
});

const handleDelete = (url) => {
    Swal.fire({
        title: t("lang.question"),
        text: t("lang.delete_record_confirm"),
        icon: "question",
        showConfirmButton: true,
        showCancelButton: true,
        confirmButtonText: t("lang.yes"),
        cancelButtonText: t("lang.no"),
    }).then(async ({ isConfirmed }) => {
        if (isConfirmed) {
            await deleteData(url)
                .then(({ data }) => {
                    instance.props.hotels = data;
                    toast.success(t("lang.delete_successfully"));
                })
                .catch((err) =>
                    Swal.fire({
                        title: t("lang.error"),
                        text: err?.response?.data?.message || err.message,
                        icon: "error",
                        confirmButtonText: t("lang.ok"),
                    })
                );
        }
    });
};
</script>

<template>
    <AppLayout :title="$t('lang.hotels')">
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                {{
                    $t("lang.list_arg", {
                        arg: $t("lang.hotels").toLowerCase(),
                    })
                }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg"
                >
                    <div
                        class="relative overflow-x-auto shadow-md sm:rounded-lg"
                    >
                        <Link
                            v-if="can.create"
                            :href="route('hotels.create')"
                            class="m-4"
                        >
                            {{
                                $t("lang.add_arg", {
                                    arg: $t("lang.hotel").toLowerCase(),
                                })
                            }}
                        </Link>

                        <table
                            class="w-full text-sm text-left text-gray-500 dark:text-gray-400"
                        >
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                            >
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        {{ $t("lang.hotel") }}
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        {{ $t("lang.rooms") }}
                                    </th>
                                    <th
                                        scope="col"
                                        class="flex px-6 py-3 justify-center items-center"
                                    >
                                        <VIcon
                                            name="hi-lightning-bolt"
                                            class="w-4 h-4 text-gray-500 dark:text-gray-200"
                                        />
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="hotel in hotels.data"
                                    :key="hotels.id"
                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
                                >
                                    <td
                                        class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap"
                                    >
                                        {{ hotel.name }}
                                    </td>
                                    <td
                                        class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap w-28"
                                    >
                                        {{ hotel.rooms?.length || 0 }}
                                    </td>
                                    <td class="px-6 py-4 w-44 items-center">
                                        <Tooltip
                                            v-if="can.update"
                                            :id="`tooltip-edit-${hotel.id}`"
                                            :title="
                                                $t('lang.edit_arg', {
                                                    arg: $t(
                                                        'lang.hotel'
                                                    ).toLowerCase(),
                                                })
                                            "
                                        >
                                            <Link
                                                :data-tooltip-target="`tooltip-edit-${hotel.id}`"
                                                :href="
                                                    route(
                                                        'hotels.edit',
                                                        hotel.id
                                                    )
                                                "
                                            >
                                                <VIcon
                                                    name="hi-pencil-alt"
                                                    class="w-4 h-4 text-gray-300 dark:text-gray-200"
                                                />
                                            </Link>
                                        </Tooltip>
                                        <Tooltip
                                            v-if="can.delete"
                                            :id="`tooltip-delete-${hotel.id}`"
                                            :title="
                                                $t('lang.delete_arg', {
                                                    arg: $t(
                                                        'lang.hotel'
                                                    ).toLowerCase(),
                                                })
                                            "
                                        >
                                            <DangerButton
                                                type="button"
                                                @click="
                                                    handleDelete(
                                                        route(
                                                            'hotels.destroy',
                                                            hotel.id
                                                        )
                                                    )
                                                "
                                                :data-tooltip-target="`tooltip-delete-${hotel.id}`"
                                            >
                                                <VIcon
                                                    name="hi-trash"
                                                    class="w-4 h-4 text-gray-300 dark:text-gray-200"
                                                />
                                            </DangerButton>
                                        </Tooltip>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="p-4">
                            <Pagination :links="hotels?.links" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
