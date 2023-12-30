<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import ActionSection from '@/Components/ActionSection.vue';
import ConfirmationModal from '@/Components/ConfirmationModal.vue';
import DangerButton from '@/Components/DangerButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

const props = defineProps({
    team: Object,
});

const confirmingTeamDeletion = ref(false);
const form = useForm({});

const confirmTeamDeletion = () => {
    confirmingTeamDeletion.value = true;
};

const deleteTeam = () => {
    form.delete(route('teams.destroy', props.team), {
        errorBag: 'deleteTeam',
    });
};
</script>

<template>
    <ActionSection>
        <template #title>
            {{ $t('lang.pages.teams.team_settings.delete_title') }}
        </template>

        <template #description>
            {{ $t('lang.pages.teams.team_settings.delete_description') }}
        </template>

        <template #content>
            <div class="max-w-xl text-sm text-gray-600 dark:text-gray-400">
                {{ $t('lang.pages.teams.team_settings.delete_description2') }}
            </div>

            <div class="mt-5">
                <DangerButton @click="confirmTeamDeletion">
                    {{ $t('lang.pages.teams.team_settings.delete_title') }}
                </DangerButton>
            </div>

            <!-- Delete Team Confirmation Modal -->
            <ConfirmationModal :show="confirmingTeamDeletion" @close="confirmingTeamDeletion = false">
                <template #title>
                    {{ $t('lang.pages.teams.team_settings.delete_title') }}
                </template>

                <template #content>
                    {{ $t('lang.pages.teams.team_settings.delete_confirmation') }}
                </template>

                <template #footer>
                    <SecondaryButton @click="confirmingTeamDeletion = false">
                        {{ $t('lang.cancel') }}
                    </SecondaryButton>

                    <DangerButton
                        class="ms-3"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="deleteTeam"
                    >
                    {{ $t('lang.pages.teams.team_settings.delete_title') }}
                    </DangerButton>
                </template>
            </ConfirmationModal>
        </template>
    </ActionSection>
</template>
