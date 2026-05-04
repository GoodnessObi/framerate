<template>
    <AppLayout :title="post.title">

        <Container>
            <div class="rounded-lg bg-white p-6 shadow-sm sm:p-8">
                <h1
                    class="mb-2 text-balance text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl"
                >
                    {{ post.title }}
                </h1>

                <p class="mb-6 text-sm text-gray-500">
                    {{ formatDate(post.created_at) }} by {{ post.user.name }}
                </p>

                <article class="prose prose-gray max-w-none">
                    <pre
                        class="not-prose whitespace-pre-wrap break-words rounded-lg bg-gray-50 p-4 font-sans text-sm text-gray-900"
                    >{{ post.body }}</pre>
                </article>
            </div>
        </Container>
    </AppLayout>
</template>

<script setup>
import Container from '@/Components/Container.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import formatDate from '@/utililities/formatDate';


const props = defineProps({
    post: Object,
});
</script>