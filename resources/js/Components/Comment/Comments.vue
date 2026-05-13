<template>
    <div class="mt-8 rounded-lg bg-white p-6 shadow-sm sm:p-8">
        <!-- Title -->
        <h2 class="mb-4 text-2xl font-bold tracking-tight text-gray-900">Comments</h2>

        <!-- Form -->
        <CommentForm v-if="$page.props.auth.user" :form="commentForm" @submit="addComment" @update="updateComment" @cancel="cancelEdit" :isEditing="!!commentIdBeingEdited"  />

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
             <ul class="space-y-2">
                <li v-for="comment in comments.data" :key="comment.id">
                    <CommentCard :comment="comment" @delete="deleteComment" @edit="editComment" :isEditing="!!commentIdBeingEdited" />
                </li>
            </ul>

            <!-- Pagination -->
            <Pagination :meta="comments.meta" :only="['comments']" />
        </div>
    </div>
</template>



<script setup>
import CommentCard from '@/Components/Comment/CommentCard.vue';
import CommentForm from '@/Components/Comment/CommentForm.vue';
import Pagination from '@/Components/Pagination.vue';
import { Link, router, useForm } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

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

const commentForm = useForm({
    body: '',
});

const commentIdBeingEdited = ref(null);
const commentBeingEdited = computed(() => props.comments.data.find(comment => comment.id === commentIdBeingEdited.value));
const editComment = (commentId) => {
    commentIdBeingEdited.value = commentId;
    commentForm.body = commentBeingEdited.value.body;
}

const cancelEdit = () => {
    commentIdBeingEdited.value = null;
    commentForm.reset();
}

const addComment = () => {
    commentForm.post(route('posts.comments.store', props.postId), {
        preserveScroll: true,
        onSuccess: () => {
            commentForm.reset();
        },
    });
};

const updateComment = () => {
    commentForm.put(route('comments.update', { comment: commentIdBeingEdited.value, page: props.comments.meta.current_page }), {
        preserveScroll: true,
        onSuccess: () => cancelEdit(),
    });
}

const deleteComment = (commentId) => {
    router.delete(route('comments.destroy', { comment: commentId, page: props.comments.meta.current_page }), {
        preserveScroll: true,
    });
};
</script>
