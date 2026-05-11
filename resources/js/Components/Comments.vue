<template>
    <div class="mt-8 rounded-lg bg-white p-6 shadow-sm sm:p-8">
        <!-- Title -->
        <h2 class="mb-4 text-2xl font-bold tracking-tight text-gray-900">Comments</h2>

        <!-- Form -->
        <form v-if="$page.props.auth.user"  class="mb-6 rounded-xl border border-gray-200 bg-gray-50/80 p-4 sm:p-5" @submit.prevent="storeComment">
            <div class="space-y-3">
                <div>
                    <InputLabel for="body" value="Add your comment" class="sr-only" />
                    <Textarea
                        id="body"
                        v-model="commentForm.body"
                        class="mt-2 block min-h-28 w-full resize-y"
                        placeholder="Share your thoughts..."
                    />
                    <InputError :message="commentForm.errors.body" class="mt-2" />
                </div>

                <div class="flex items-center justify-between gap-4">
                    <PrimaryButton type="submit" :disabled="commentForm.processing">
                        Add Comment
                    </PrimaryButton>
                </div>
            </div>
        </form>

        <!-- Empty state -->
        <div v-if="comments.data.length === 0" class="mb-4 rounded-lg border border-gray-200 bg-gray-50 p-4 last:mb-0">
            <div class="mb-3 flex items-center gap-3">
                <p v-if="$page.props.auth.user" class="text-sm text-gray-500">Be the first to comment</p>
                <p v-else class="text-sm text-gray-500">Please <Link href="/login" class="text-indigo-600 hover:text-indigo-900">login</Link> to comment</p>
            </div>
        </div>

        <!-- Comments list -->
        <div v-else>
            <!-- Comments -->
            <div class="mb-4 rounded-lg border border-gray-200 bg-gray-50 p-4 last:mb-0"
                v-for="comment in comments.data"
                :key="comment.id"
            >
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

            <!-- Pagination -->
            <Pagination :meta="comments.meta" :only="['comments']" />
        </div>
    </div>
</template>



<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Pagination from '@/Components/Pagination.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Textarea from '@/Components/Textarea.vue';
import formatDate from '@/utililities/formatDate';
import { Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    postId: {
        type: Number,
        required: true,
    },
    comments: {
        type: Object,
        required: true,
    },
});


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

const commentForm = useForm({
    body: '',
});

const storeComment = () => {
    commentForm.post(route('posts.comments.store', props.postId), {
        preserveScroll: true,
        onSuccess: () => {
            commentForm.reset();
        },
    });
};


</script>
