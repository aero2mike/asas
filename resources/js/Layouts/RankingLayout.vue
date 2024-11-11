<script setup>
import JetBanner from "@/Jetstream/Banner.vue";
import xFooter from "@/Components/Footer.vue";
import { Head } from "@inertiajs/vue3";
import xHeader from "@/Components/Header.vue";
import "vue3-carousel/dist/carousel.css";
const props = defineProps({
    title: {
        type: String,
    },
});

</script>
<template>
    <div class="relative">
        <Head :title="title" />
        <jet-banner />
        <div class="">
            <xHeader :user="$page.props.user"/>

            <!-- Page Content -->
            <main class="mx-auto min-h-screen">
                <div class="w-full text-white">
                    <slot></slot>
                </div>
            </main>
            <x-footer />
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
