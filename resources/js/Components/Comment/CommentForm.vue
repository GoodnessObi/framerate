<template>
    <form class="mb-6 rounded-xl border border-gray-200 bg-gray-50/80 p-4 sm:p-5" @submit.prevent="$emit('submit')">
        <div class="space-y-3">
            <div>
                <InputLabel for="body" value="Add your comment" class="sr-only" />
                <Textarea
                    id="body"
                    v-model="form.body"
                    class="mt-2 block min-h-28 w-full resize-y"
                    placeholder="Share your thoughts..."
                />
                <InputError :message="form.errors.body" class="mt-2" />
            </div>

            <div class="flex items-center justify-between gap-4">
                <PrimaryButton type="submit" :disabled="form.processing">
                    Add Comment
                </PrimaryButton>
            </div>
        </div>
    </form>
</template>

<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Textarea from '@/Components/Textarea.vue';

defineProps({
    form: {
        type: Object,
        required: true,
    },
});

defineEmits(['submit']);

</script>
