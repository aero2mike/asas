<script setup>
import xHeader from "@/Components/Header.vue";
import { Head, router } from "@inertiajs/vue3";
import { ref, onMounted } from "vue";

const props = defineProps({
    title: {
        type: String,
        required: true,
    },
    categories: {
        type: Object,
        required: true,
    },
});

const navigation = ref([]);
const isMobileMenuOpen = ref(false);

function getPosts(category_id) {
    const filteredPosts = [];

    props.categories.forEach((category) => {
        category.posts.forEach((post) => {
            if (post.category_id === category_id) {
                filteredPosts.push({
                    category_id: post.category_id,
                    title: post.title,
                    url: `/wiki/${category.slug}/${post.slug}`,
                    active: false,
                });
            }
        });
    });

    return filteredPosts;
}

function getCategories() {
    props.categories.forEach((category) => {
        const postInCategory = getPosts(category.id);
        if (postInCategory.length === 0) return;
        navigation.value.push({
            title: category.name,
            links: postInCategory,
        });
    });
}

function changePost(url) {
    router.get(
        url,
        {},
        {
            preserveState: true,
            preserveScroll: true,
            onSuccess: () => {
                const mobileMenu = document.getElementById("mobile-menu");
                navigation.value.forEach((nav) => {
                    nav.links.forEach((link) => {
                        link.active = link.url === url;
                    });
                });
                if (!mobileMenu.classList.contains("hidden")) {
                    toggleMobileMenu();
                }
            },
        }
    );
}

function toggleMobileMenu() {
    const mobileMenu = document.getElementById("mobile-menu");
    const iconClose = document.getElementById("icon-close");

    if (mobileMenu.classList.contains("hidden")) {
        // Mostrar el menú
        mobileMenu.classList.remove("hidden");
        mobileMenu.classList.add("animated", "slideInLeft");
        iconClose.classList.remove("hidden");
    } else {
        // Ocultar el menú
        mobileMenu.classList.add("hidden");
        mobileMenu.classList.remove("animated", "slideInLeft");
        iconClose.classList.add("hidden");
    }
}
onMounted(() => {
    getCategories();
});
</script>

<template>
    <div class="h-full justify-center">
        <Head :title="title" />
        <xHeader :user="$page.props.user" />

        <div
            style="
                background-image: url('/img/bg-main.jpg');
                background-size: cover;
                background-attachment: fixed;
                background-position: top;
                overflow: hidden;
            "
        >
            <div class="bg-white/30 bg-opacity-70 grid md:grid-cols-8 h-screen">
                <aside
                    id="default-sidebar"
                    class="hidden md:block md:col-span-2 lg:col-span-2 xl:col-span-1 h-screen transition-transform -translate-x-full sm:translate-x-0 z-20"
                    aria-label="Sidebar"
                >
                    <div
                        class="h-screen px-3 py-4 overflow-y-auto bg-white shadow-md"
                    >
                        <ul class="space-y-2 md:mt-16 lg:mt-36">
                            <li v-for="(nav, index) in navigation" :key="index">
                                <h2
                                    class="text-base lg:text-lg xl:text-xl text-black mb-2 font-semibold ml-3"
                                >
                                    {{ nav.title }}
                                </h2>
                                <ul>
                                    <li
                                        v-for="(navLink, subIndex) in nav.links"
                                        :key="subIndex"
                                    >
                                        <a
                                            @click="changePost(navLink.url)"
                                            :class="{
                                                'text-sky-600	font-medium	':
                                                    navLink.active,
                                                'flex items-center text-black rounded-lg    hover:font-medium':
                                                    !navLink.active,
                                            }"
                                            class="my-1 ml-6 items-center transition hover:text-black cursor-pointer rounded-lg"
                                        >
                                            {{ navLink.title }}
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </aside>

                <!-- Main content -->
                <div
                    class="overflow-auto mt-10 pt-10 md:py-10 md:col-span-6 xl:col-span-7 lg:mt-24"
                >
                    <main class="overflow-x-hidden bg-transparent">
                        <slot></slot>
                    </main>
                </div>
            </div>
        </div>
        <div class="relative">
            <button
                @click="toggleMobileMenu"
                class="absolute left-0 bottom-20 m-4 bg-cyan-500 text-white w-12 h-12 rounded-full focus:outline-none"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="w-6 h-6 mx-auto"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 0 1 0 3.75H5.625a1.875 1.875 0 0 1 0-3.75Z"
                    />
                </svg>
            </button>
        </div>
        <div
            id="mobile-menu"
            class="hidden fixed inset-0 z-10 transition-opacity bg-black bg-opacity-25 w-full"
        >
            <div class="absolute h-screen w-full overflow-y-auto">
                <div class="absolute px-3 py-4 bg-white shadow-md w-full">
                    <ul class="space-y-2 mt-14">
                        <div class="md:hidden relative">
                            <button
                                @click="toggleMobileMenu"
                                type="button"
                                class="h-7 w-7 rounded-md transition bg-gray-100 absolute right-0"
                                aria-label="Toggle navigation"
                            >
                                <svg
                                    id="icon-close"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    class="w-7 h-7 text-gray-500"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M6 18 18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                        <li v-for="(nav, index) in navigation" :key="index">
                            <h2
                                class="text-base text-black mb-2 font-semibold ml-3"
                            >
                                {{ nav.title }}
                            </h2>
                            <ul>
                                <li
                                    v-for="(navLink, subIndex) in nav.links"
                                    :key="subIndex"
                                >
                                    <a
                                        @click="changePost(navLink.url)"
                                        :class="{
                                            'text-sky-600	font-medium':
                                                navLink.active,
                                            'flex items-center text-black rounded-lg hover:font-medium':
                                                !navLink.active,
                                        }"
                                        class="my-1 ml-6 items-center transition hover:text-black cursor-pointer rounded-lg"
                                    >
                                        {{ navLink.title }}
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.animated {
    animation-duration: 0.3s;
    animation-fill-mode: both;
}
@keyframes slideInLeft {
    0% {
        opacity: 0;
        transform: translateX(-100%);
    }
    100% {
        opacity: 1;
        transform: translateX(0);
    }
}

.slideInLeft {
    animation-name: slideInLeft;
}
</style>
