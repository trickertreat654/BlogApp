<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    blogs: {
        type: Array,
        required: true
    }   
})
</script>

<template>
    <Head title="Blog" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">Blog</h2>
        </template>
        <div class="py-12">
                <article class="mx-auto mt-16 prose dark:prose-invert lg:prose-xl prose-code:{html}">
                        <div  class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-2">
                                <div v-for="blog in blogs" :key="blog.id" class="p-4 border border-red-500 rounded-lg text-md dark:prose-invert">
                                    <h1>{{ blog.title }}</h1>
                                    <p>Hi</p>
                                    <Link class="px-2 py-2 bg-indigo-200 rounded-lg dark:bg-indigo-700" as="button" :href="route('blogs.show', { blog: blog.id })">Read more</Link>
                                    <Link class="px-2 py-2 mx-4 bg-indigo-200 rounded-lg dark:bg-indigo-700" as="button" :href="route('blogs.edit', { blog: blog.id })">Edit</Link>
                                    <Link method="delete" class="px-2 py-2 bg-indigo-200 rounded-lg dark:bg-indigo-700" as="button" :href="route('blogs.destroy', { blog: blog.id })">Delete</Link>
                                </div>
                            </div>
                   </article>
        </div>
    </AuthenticatedLayout>
</template>