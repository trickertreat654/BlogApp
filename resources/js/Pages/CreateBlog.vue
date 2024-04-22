<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
// import markdown1 from '@/Components/testMarkdown.md';
import { Head, useForm, usePage } from '@inertiajs/vue3';

import { ref } from 'vue';
import VueMarkdown from 'vue-markdown-render'
import { useStorage } from '@vueuse/core'
import InputLabel from '@/Components/InputLabel.vue'
import { Link } from '@inertiajs/vue3'
import { useClipboard } from '@vueuse/core'



const props = defineProps({
    pictures: {
        type: Array,
        default: []
    },
    url: String
})

const source = ref('Hello')

const { text, copy, copied, isSupported } = useClipboard({ source })

const theDefault = { title: '', content: '' };

// Use storage to persist form state
const state = useStorage('vue-use-local-storage', theDefault);
// const state = useStorage('vue-use-local-storage', theDefault);

console.log('Initial state:', state.value);

console.log('Initial title:', localStorage);
console.log('Initial title1:', state);

const form = useForm({
    title: state.value.title,
    content: state.value.content
});
const pictureForm = useForm({
    //   name: null,
    picture: null,
})

function handleFileUpload() {
  pictureForm.post('/blogs/pictures')
}

const clearState = () => {
    state.value = { ...theDefault };
    console.log('State after clearing:', state.value);
};

const submit = () => {
    form.title = state.value.title;
    form.content = state.value.content;
    form.post(route('blogs.store'), {
        onSuccess: () => {
            localStorage.setItem("vue-use-local-storage", { title: '', content: '' });
            // state.value = null
            // state = useStorage('vue-use-local-storage', theDefault);



            console.log('State post-submission:', state.value);
        },
    });
};
// console.log(path)

const concat = (path) => {
    return '![What you see](' + path + ')';
};
const isRow = ref(true)

const value = 'Title'
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-row items-center space-x-4">
                <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">Service</h2>
                <button class="p-4 prose bg-indigo-200 rounded-lg dark:bg-indigo-700 text-md dark:prose-invert "
                    @click="isRow = !isRow">{{ isRow ? 'Row' : 'Column' }}</button>
            </div>
        </template>



        <div class="py-12">
            <!-- <div class="mx-auto max-w-7xl sm:px-6 lg:px-8"> -->
            <!-- get raw mark down -->

            <div class="flex flex-col w-full">
                <div class="flex flex-row mx-auto mb-24 ">

                    <div class="w-full max-w-xl mx-auto prose dark:prose-invert h-96">
                        <form class="h-full" @submit.prevent="submit">
                            <InputLabel :value />

                            <input class=" dark:bg-gray-800" v-model="state.title" label="Title" type="text"
                                name="title" autofocus />

                            <textarea class="w-full h-full dark:bg-gray-800" type="text" v-model="state.content" />
                            <button class="p-4 bg-indigo-200 rounded-lg dark:bg-indigo-700 text-md "
                                type="submit">Save</button>

                        </form>
                    </div>
                    <!-- <img class="bg-green-400 w-96" :src="url" alt="">
                    {{ url }} -->

                    <div class="w-full prose prose-invert">
                        <form @submit.prevent="handleFileUpload">
                            <!-- <input type="text" v-model="form.name" /> -->
                            <input type="file" @input="pictureForm.picture = $event.target.files[0]" />
                            <progress v-if="pictureForm.progress" :value="pictureForm.progress.percentage" max="100">
                                {{ form.progress.percentage }}%
                            </progress>
                            <button type="submit">Submit</button>
                        </form>
                        <div class="grid w-full grid-cols-2 ">
                            <div v-for="picture in props.pictures" class="">
                                <img class="w-36" :src="picture.path" alt="">
                                <div v-if="isSupported">
                                    <button @click="copy(concat(picture.path))">
                                        <!-- by default, `copied` will be reset in 1.5s -->
                                        <span v-if="!copied">Copy</span>
                                        <span v-else>Copied!</span>
                                    </button>
                                    <p>Current copied: <code>{{ source || 'none' }}</code></p>
                                </div>
                                <p v-else>
                                    Your browser does not support Clipboard API
                                </p>

                            </div>

                        </div>

                    </div>

                </div>
                <article class="mx-auto mt-16 prose dark:prose-invert lg:prose-xl prose-code:{html}">


                    <!-- {{ markdown }} -->
                    <VueMarkdown :source="state.content" />
                </article>
            </div>

            <!-- </div> -->
        </div>
    </AuthenticatedLayout>
</template>