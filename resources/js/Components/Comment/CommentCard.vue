<template>
    <div class="rounded-lg border border-gray-200 bg-gray-50 p-4">
        <div class="mb-3 flex items-center gap-3">
            <div
                class="flex h-10 w-10 items-center justify-center rounded-full bg-indigo-100 text-xs font-semibold text-indigo-600"
            >
                {{ getNameAcronym(comment.user.name) }}
            </div>
            <div>
                <p class="text-sm font-medium text-gray-900">
                    {{ comment.user.name }}
                </p>
                <p class="text-xs text-gray-500">
                    {{ formatDate(comment.created_at) }}
                </p>
            </div>
        </div>

        <p class="whitespace-pre-wrap break-words text-gray-800">{{ comment.body }}</p>

        <div class="mt-2 flex flex-wrap items-center justify-end gap-x-4 gap-y-1 empty:hidden">
            <form v-if="comment.can?.update" @submit.prevent="$emit('edit', comment.id)">
                <button
                    type="submit"
                    class="rounded-md bg-transparent px-0 py-0.5 text-sm font-medium text-gray-600 transition hover:text-gray-900 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:text-gray-400 disabled:opacity-60 disabled:hover:text-gray-400"
                    :disabled="isEditing"
                >
                    Edit
                </button>
            </form>
            <form v-if="comment.can?.delete" @submit.prevent="$emit('delete', comment.id)">
                <button
                    type="submit"
                    class="rounded-md bg-transparent px-0 py-0.5 text-sm font-medium text-red-600 transition hover:text-red-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-red-500 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:text-gray-400 disabled:opacity-60 disabled:hover:text-gray-400"
                    :disabled="isEditing"
                >
                    Delete
                </button>
            </form>
        </div>
    </div>
</template>

<script setup>
import formatDate from '@/utililities/formatDate';

const props = defineProps({
    comment: {
        type: Object,
        required: true,
    },
    isEditing: {
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits(['delete', 'edit']);


const getNameAcronym = (name) => {
    if (!name) {
        return 'NA';
    }

    return name
        .trim()
        .split(/\s+/)
        .slice(0, 2)
        .map((part) => part.charAt(0).toUpperCase())
        .join('');
};

</script>