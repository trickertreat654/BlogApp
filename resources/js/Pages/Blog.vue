<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
// import markdown1 from '@/Components/testMarkdown.md';
import { Head, useForm } from '@inertiajs/vue3';

import { ref } from 'vue';
import VueMarkdown from 'vue-markdown-render'


defineProps({
    blogs: {
        type: Array,
        required: true
    }   
})


const form = useForm({
    title: 'bobo',
    content: ''
})



</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">Service</h2>
        </template>
        <div class="py-12">
            <!-- <div class="mx-auto max-w-7xl sm:px-6 lg:px-8"> -->
                <!-- get raw mark down -->

              
                <article class="mx-auto mt-16 prose dark:prose-invert lg:prose-xl prose-code:{html}">
                       
                        
                       <!-- {{ markdown }} -->
                       <VueMarkdown v-for="blog in blogs" :key="blog.id" :source="blog.content"/>
                   </article>
            <!-- </div> -->
        </div>
    </AuthenticatedLayout>
</template>