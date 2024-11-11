<script setup>
import { Link, usePage } from "@inertiajs/vue3";
import { onMounted, ref, reactive } from "vue";
import { getFormatNumber } from "@/helpers";
import JetButton from "@/Jetstream/Button.vue";
const props = defineProps({
    title: String,
    char_name: String,
    guild_name: String,
    guild_id: Number,
    score: Number,
    type: String,
    bg: String,
});
const ranking_url = usePage().props.rankings_url;

const url = ref("");
async function get_emblem_url() {
    if (props.guild_id == null) {
        return;
    }
    await axios
        .get(`/api/${props.guild_id}/emblem`)
        .then((response) => {
            url.value = response.data.url;
        })
        .catch((error) => {
            console.log(error);
        });
}
onMounted(() => {
    get_emblem_url();
});
</script>

<template>
    <div class="flex flex-col justify-center items-center">
        <div
            class="!z-5 relative flex flex-col rounded-[20px] max-w-[300px] bg-white bg-clip-border shadow-3xl shadow-shadow-500 flex flex-col w-full !p-4 3xl:p-![18px] bg-white undefined">
            <div class="h-full w-full">
                <div class="relative w-full">
                    <img src="/img/main_bg.jpg"
                        class="mb-3 h-full w-full rounded-xl 3xl:h-full 3xl:w-full relative" alt="">
                    <div class="absolute flex top-0 left-0 w-full h-full rounded-xl items-center justify-center">
                        <img :src="`/rochar/?/character/${char_name}`" alt="">
                    </div>
                </div>
                <div class="mb-3 flex items-center justify-between px-1 md:items-start">
                    <div class="mb-2">
                        <p class="text-lg font-bold text-gray-700"> {{ title }} </p>
                        <p class="mt-1 text-sm font-medium text-gray-600 md:mt-2">{{ (char_name ?? 'N/A') }} </p>
                        <div class="flex items-center">
                            <p class="mt-1 text-sm font-medium text-gray-600 md:mt-2">{{ (guild_name ?? 'No guild ❌') }}</p>
                            <img v-if="url" :src="'/'+url" class="w-6 h-6 ml-2" alt="">
                        </div>
                    </div>
                    <div class="flex flex-row-reverse md:mt-2 lg:mt-0">
                        <font-awesome-icon class="text-2xl p-1 w-9 text-yellow-500" icon="fa-solid fa-trophy" />
                    </div>
                </div>
                <div class="flex items-center justify-between md:items-center lg:justify-between ">
                    <div class="flex">
                        <p class="!mb-0 text-sm font-bold text-gray-500">Current Points: {{ getFormatNumber(score) }} </p>
                    </div>
                    <div class="flex flex-row-reverse md:mt-2 lg:mt-0">
                        <Link :href="ranking_url[type]">
                            <JetButton is>Rank</JetButton>
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>