<script setup>
import { defineProps, computed } from "vue";
const props = defineProps(["post"]);
</script>

<template>
    <article class="">
        <div v-html="props.post.body" class="overflow-x-auto ck-content"></div>
    </article>
</template>
