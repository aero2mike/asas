<script setup>
import { Menu, MenuButton, MenuItem, MenuItems } from "@headlessui/vue";
import { onMounted, ref } from "vue";

const langtype = ref("US");

function changeLang(lang) {
    langtype.value = lang;
    localStorage.setItem("lang", lang);
    location.reload();

}

onMounted(() => {
    const lang = localStorage.getItem("lang");
    if (lang) {
        langtype.value = lang;
    }
});
</script>

<template>
    <Menu as="div" class="relative inline-block text-left my-auto mr-5">
        <div>
            <MenuButton
                class="absloute  w-full justify-center gap-x-1.5 rounded-md bg-white "
            >
                <country-flag
                    :country="langtype"
                    :size="normal"
                    :squircle="true"/>
            </MenuButton>
        </div>

        <transition
            enter-active-class="transition ease-out duration-100"
            enter-from-class="transform opacity-0 scale-95"
            enter-to-class="transform opacity-100 scale-100"
            leave-active-class="transition ease-in duration-75"
            leave-from-class="transform opacity-100 scale-100"
            leave-to-class="transform opacity-0 scale-95"
        >
            <MenuItems
                class="absolute right-0 z-10 mt-2 w-56 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
            >
                <div class="py-1">
                    <MenuItem v-slot="{ active }">
                        <span
                            @click="changeLang('US')"
                            :class="[
                                active
                                    ? 'bg-gray-100 text-gray-900'
                                    : 'text-gray-700',
                                'block px-4 py-2 text-sm cursor-pointer flex items-center',
                            ]"
                        >
                            <country-flag
                                :country="'US'"
                                :size="20"
                                :squircle="true"
                            />
                            <span class="ml-2 mt-2">English</span>
                        </span>
                    </MenuItem>
                    <MenuItem v-slot="{ active }">
                        <span
                            @click="changeLang('PT')"
                            :class="[
                                active
                                    ? 'bg-gray-100 text-gray-900'
                                    : 'text-gray-700',
                                'block px-4 py-2 text-sm cursor-pointer flex items-center',
                            ]"
                        >
                            <country-flag
                                :country="'PT'"
                                :size="20"
                                :squircle="true"
                            />
                            <span class="ml-2 mt-2">Português</span>
                        </span>
                    </MenuItem>
                    <MenuItem v-slot="{ active }">
                        <span
                            @click="changeLang('ES')"
                            :class="[
                                active
                                    ? 'bg-gray-100 text-gray-900'
                                    : 'text-gray-700',
                                'block px-4 py-2 text-sm cursor-pointer flex items-center',
                            ]"
                        >
                            <country-flag
                                :country="'ES'"
                                :size="20"
                                :squircle="true"
                            />
                            <span class="ml-2 mt-2">Español</span>
                        </span>
                    </MenuItem>
                    <MenuItem v-slot="{ active }">
                        <span
                            @click="changeLang('FR')"
                            :class="[
                                active
                                    ? 'bg-gray-100 text-gray-900'
                                    : 'text-gray-700',
                                'block px-4 py-2 text-sm cursor-pointer flex items-center',
                            ]"
                        >
                            <country-flag
                                :country="'FR'"
                                :size="5"
                                :squircle="true"
                            />
                            <span class="ml-2 mt-2">Français</span>
                        </span>
                    </MenuItem>
                </div>
            </MenuItems>
        </transition>
    </Menu>
</template>
