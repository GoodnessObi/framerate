<template>
    <div class="mt-8 rounded-lg bg-white p-6 shadow-sm sm:p-8">
        <!-- Title -->
        <h2 class="mb-4 text-2xl font-bold tracking-tight text-gray-900">Comments</h2>

        <!-- Form -->
        <CommentForm v-if="$page.props.auth.user" :post-id="postId" />

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
            <CommentCard
                v-for="comment in comments.data"
                :key="comment.id"
                :comment="comment"
            />

            <!-- Pagination -->
            <Pagination :meta="comments.meta" :only="['comments']" />
        </div>
    </div>
</template>



<script setup>
import CommentCard from '@/Components/Comment/CommentCard.vue';
import CommentForm from '@/Components/Comment/CommentForm.vue';
import Pagination from '@/Components/Pagination.vue';
import { Link } from '@inertiajs/vue3';

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
</script>
