<script setup>
import { useForm } from '@inertiajs/vue3'

const pictureForm = useForm({
//   name: null,
  avatar: null,
})

function submit() {
  pictureForm.post('/blogs/pictures')
}
</script>

<template>
  <form @submit.prevent="submit">
    <!-- <input type="text" v-model="form.name" /> -->
    <input type="file" @input="pictureForm.avatar = $event.target.files[0]" />
    <progress v-if="pictureForm.progress" :value="pictureForm.progress.percentage" max="100">
      {{ form.progress.percentage }}%
    </progress>
    <button type="submit">Submit</button>
  </form>
</template>