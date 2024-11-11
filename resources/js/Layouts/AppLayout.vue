<script setup>
import JetBanner from "@/Jetstream/Banner.vue";
import xFooter from "@/Components/Footer.vue";
import xHeader from "@/Components/Header.vue";
import { Head } from "@inertiajs/vue3";
import xAlert from "@/Components/Alert.vue";
import "vue3-carousel/dist/carousel.css";

const props = defineProps({
    title: {
        type: String,
        required: true,
    },
});

</script>

<template>
    <div class="relative">
        <Head :title="title" />
        <jet-banner />
        <div class="">
            <x-header :user="$page.props.user"/>
            <!-- Page Content -->
            <main class="mx-auto">
                <div class="w-full text-white">
                    <slot></slot>
                </div>
            </main>
            <x-footer />
            <x-alert />
        </div>
    </div>
</template>

<style scoped>
main {
    /* The image used */
    background-image: url("/img/bg-main.jpg");
    background-size: cover;
    background-attachment: fixed;
    /* Full height */
    width: 100%;
    height: auto;
}
</style>
