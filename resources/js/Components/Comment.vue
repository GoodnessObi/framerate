<template>
    <div class="mb-4 rounded-lg border border-gray-200 bg-gray-50 p-4 last:mb-0">
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
    </div>
</template>

<script setup>
import formatDate from '@/utililities/formatDate';

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

defineProps({
    comment: {
        type: Object,
        required: true,
    },
});
</script>
