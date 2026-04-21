<template>
   <AppLayout title="Posts">
      <Container>
         <ul class="divide-y divide-gray-200 bg-white">
            <li v-for="post in posts" :key="post.id" class="px-2 py-4">
               <span class="font-bold text-lg" >
                  {{ post.title }}
               </span>
            </li>
         </ul>
      </Container>
   </AppLayout>
</template>


<script setup>
import Container from '@/Components/Container.vue';
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({
   posts: Array,
});


</script>
