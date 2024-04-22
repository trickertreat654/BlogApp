<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
// import markdown1 from '@/Components/testMarkdown.md';
import { Head, useForm } from '@inertiajs/vue3';

import { ref } from 'vue';
import VueMarkdown from 'vue-markdown-render'
import TextInput from '@/Components/TextInput.vue'

import { useStorage } from '@vueuse/core'
import InputLabel from '@/Components/InputLabel.vue'



const props = defineProps({
    blog: {
        type: Object,
        required: true
    }
})

const theDefault = {
    title: props.blog.title,
    content: props.blog.content
}

const state = useStorage('vue-use-local-storage', theDefault)
const state2 = useStorage('vue-use-local-storage', theDefault)

const form = useForm({
    title: state.value.title,
    content: state.value.content
})


const submit = () => {
    form.title = state.value.title
    form.content = state.value.content

    form.patch(route('blogs.update', { blog: props.blog.id }))


    
}



const isRow = ref(true)

const value = 'Title'
 
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
            <div class="w-full ">
    
                <div class="mx-auto w-fit">

                    <button class="p-4 mx-auto prose bg-indigo-200 rounded-lg dark:bg-indigo-700 text-md dark:prose-invert " @click="[state.content,state.title] = ['','']">Clear</button>
                </div>
            </div>
            <!-- <div class="mx-auto max-w-7xl sm:px-6 lg:px-8"> -->
                <!-- get raw mark down -->

               <div class="flex flex-row" :class="isRow ? 'flex-row':'flex-col'">

                <div class="w-full max-w-xl mx-auto prose dark:prose-invert h-96">
                    <form @submit.prevent="submit">
                        <InputLabel :value/>
                       <input class=" dark:bg-gray-800"
                            v-model="state.title"
                            label="Title"
                            type="text"
                            name="title"
                            autofocus/>
                        <textarea class="w-full h-64 dark:bg-gray-800" type="text" v-model="state.content"/>
                        <button class="p-4 bg-indigo-200 rounded-lg dark:bg-indigo-700 text-md " type="submit">Save</button>
                    </form>
                </div>
                   <article class="mx-auto mt-16 prose dark:prose-invert lg:prose-xl prose-code:{html}">
                       <!-- {{ markdown }} -->
                       <VueMarkdown :source="state.content"/>
                    </article>
                </div> 
        </div>
    </AuthenticatedLayout>
</template>