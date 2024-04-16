<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
// import markdown1 from '@/Components/testMarkdown.md';
import { Head, useForm } from '@inertiajs/vue3';

import { ref } from 'vue';
import VueMarkdown from 'vue-markdown-render'


const form = useForm({
    title: 'bobo',
    content: ''
})

const isRow = ref(true)

 
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-row items-center space-x-4">
                <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">Service</h2>
                <button class="p-4 prose bg-indigo-200 rounded-lg dark:bg-indigo-700 text-md dark:prose-invert " @click="isRow = !isRow">{{ isRow ? 'Row': 'Column' }}</button>
            </div>
        </template>
        <div class="py-12">
            <!-- <div class="mx-auto max-w-7xl sm:px-6 lg:px-8"> -->
                <!-- get raw mark down -->

               <div class="flex flex-row" :class="isRow ? 'flex-row':'flex-col'">

                <div class="w-full max-w-xl mx-auto prose dark:prose-invert h-96">
                    <form @submit.prevent="form.post(route('blogs.store'))">

                        <textarea class="w-full h-full dark:bg-gray-800" type="text" v-model="form.content"/>
                        <button class="p-4 bg-indigo-200 rounded-lg dark:bg-indigo-700 text-md " type="submit">Save</button>

                    </form>
                </div>
                   
                   <article class="mx-auto mt-16 prose dark:prose-invert lg:prose-xl prose-code:{html}">
                       
                       
                       <!-- {{ markdown }} -->
                       <VueMarkdown :source="form.content"/>
                    </article>
                </div> 
              
            <!-- </div> -->
        </div>
    </AuthenticatedLayout>
</template>