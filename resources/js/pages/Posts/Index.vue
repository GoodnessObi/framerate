<template>
   <AppLayout title="Posts">
      <Container>
         <ul class="divide-y divide-gray-200 bg-white">
            <li
               v-for="post in posts.data"
               :key="post.id"
               class="group rounded-md  transition-colors hover:bg-gray-50 focus-within:bg-gray-50"
            >
               <Link
                  :href="route('posts.show', post.id)"
                  class="block cursor-pointer text-gray-900 px-2 py-4 outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2 focus-visible:ring-offset-white"
               >
                  <span
                     class="font-bold text-lg text-gray-900 transition-colors group-hover:text-indigo-600 group-focus-within:text-indigo-600"
                  >
                     {{ post.title }}
                  </span>
                  <p class="mt-1 text-sm text-gray-500">
                     {{ formatDate(post.created_at) }} by {{ post.user.name }}
                  </p>
               </Link>
            </li>
         </ul>
         <Pagination :meta="posts.meta" />
      </Container>
   </AppLayout>
</template>


<script setup>
import Container from '@/Components/Container.vue';
import Pagination from '@/Components/Pagination.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import formatDate from '@/utililities/formatDate';
import { Link } from '@inertiajs/vue3';

defineProps({
    posts: Object,
});


</script>
