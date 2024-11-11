<script setup>
import JetBanner from "@/Jetstream/Banner.vue";
import xFooter from "@/Components/Footer.vue";
import xHeader from "@/Components/Header.vue";
import xAlert from "@/Components/Alert.vue";
import { Head } from "@inertiajs/vue3";

const props = defineProps({
    title: String,
});

</script>
<template>
    <div class="relative">
        <Head :title="title" />
        <jet-banner />

        <div class="">
            <xHeader :user="$page.props.user" />
            <!-- Page Content -->
            <main class="mx-auto">
                <div class="w-full text-white" id="wrap">
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
