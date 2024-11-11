<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import { CheckIcon } from "@heroicons/vue/20/solid";
import { usePage } from "@inertiajs/vue3";
import { cartShop } from "@/store.js";
import { notify } from "notiwind";
import { ref, onMounted } from "vue";

const donations = usePage().props.donations;
const langtype = ref(localStorage.getItem("lang") || "US");
const extraDonation = () => {
    switch (langtype.value) {
        case "US":
            return "Extra Donation";
        case "ES":
            return "Donación Extra";
        case "PT":
            return "Doação Extra";
        case "FR":
            return "Donation Extra";
    }
};
const donaPoints = () => {
    switch (langtype.value) {
        case "US":
            return "Donation Points";
        case "ES":
            return "Puntos de donación";
        case "PT":
            return "Pontos de doação";
        case "FR":
            return "Points de don";
    }
};

const pricing = {
    frequencies: [{ value: "price", priceSuffix: "/ USD" }],
    tiers: [
        {
            id: 0,
            name: donations.packages[0].name,
            quantity: 1,
            price: { price: donations.packages[0].price },
            features: [
                `+ ${donations.packages[0].points} ${donaPoints(langtype.value)}`,
            ],
            mostPopular: false,
        },
        {
            name: donations.packages[1].name,
            id: 1,
            quantity: 1,
            price: { price: donations.packages[1].price },
            features: [
                `${donations.packages[1].points} ${donaPoints(langtype.value)}`,
                `+ ${donations.packages[1].extra_points} ${extraDonation(
                    langtype.value
                )}`,
            ],
            mostPopular: true,
        },
        {
            id: 2,
            name: `${donations.packages[2].name}`,
            quantity: 1,
            price: { price: donations.packages[2].price },
            features: [
                `${donations.packages[2].points} ${donaPoints(langtype.value)}`,
                `+ ${donations.packages[2].extra_points} ${extraDonation(
                    langtype.value
                )}`,
            ],
            gif_url: `https://cdn.discordapp.com/attachments/902586549978423347/1113952385170157648/cronus.gif`,
            mostPopular: false,
        },
        {
            id: 3,
            name: `${donations.packages[3].name}`,
            quantity: 1,
            price: { price: donations.packages[3].price },
            features: [
                `${donations.packages[3].points} ${donaPoints(langtype.value)}`,
                `+ ${donations.packages[3].extra_points} ${extraDonation(
                    langtype.value
                )}`,
            ],
            gif_url: `https://cdn.discordapp.com/attachments/902586549978423347/1113952385547653180/thor.gif`,
            mostPopular: false,
        },
        {
            id: 4,
            name: `${donations.packages[4].name}`,
            quantity: 1,
            price: { price: donations.packages[4].price },
            features: [
                `${donations.packages[4].points} ${donaPoints(langtype.value)}`,
                `+ ${donations.packages[4].extra_points} ${extraDonation(
                    langtype.value
                )}`,
            ],
            gif_url: `https://cdn.discordapp.com/attachments/902586549978423347/1113952384780091422/athena.gif`,
            mostPopular: true,
        },
        {
            id: 5,
            name: `${donations.packages[5].name}`,
            quantity: 1,
            price: { price: donations.packages[5].price },
            features: [
                `${donations.packages[5].points} ${donaPoints(langtype.value)}`,
                `+ ${donations.packages[5].extra_points} ${extraDonation(
                    langtype.value
                )}`,
            ],
            gif_url: `https://cdn.discordapp.com/attachments/902586549978423347/1113952389842616422/hercules.gif`,
            mostPopular: false,
        },
    ],
};
const frequency = ref(pricing.frequencies[0]);

function add2Cart(product) {
    cartShop().addItem(product);

    notify(
        {
            group: "success",
            title: "Success",
            text: `${product.name} added to cart`,
        },
        5000
    );
}

onMounted(() => {
    const lang = localStorage.getItem("lang") || "US";
    if (lang) {
        langtype.value = lang;
        console.log(langtype.value);
    }
});
</script>

<template>
    <GuestLayout :title="'Donations'">
        <div class="py-20 relative z-10">
            <!-- Pricing section -->
            <div class="mx-auto mt-16 max-w-7xl px-6 sm:mt-32 lg:px-8">
                <div
                    class="z- mx-auto mt-10 grid max-w-md grid-cols-1 gap-8 md:max-w-5xl md:grid-cols-2 lg:max-w-4xl xl:mx-0 xl:max-w-none xl:grid-cols-3"
                >
                    <div
                        data-aos-duration="1800"
                        data-aos="zoom-out-up"
                        method="POST"
                        v-for="tier in pricing.tiers"
                        :key="tier.id"
                        :class="[
                            tier.mostPopular
                                ? 'ring-2 ring-sky-400'
                                : 'ring-1 ring-gray-200',
                            'rounded-3xl p-8',
                            'bg-white',
                            'shadow-md',
                            'w-4/5 mx-auto',
                        ]"
                    >
                        <h2
                            :id="tier.id"
                            :class="[
                                tier.mostPopular
                                    ? 'text-sky-400'
                                    : 'text-gray-900',
                                'text-lg font-bold leading-8',
                                'text-2xl',
                            ]"
                        >
                            {{ tier.name }}
                        </h2>
                        <p
                            class="mt-6 flex items-baseline gap-x-1 justify-center"
                        >
                            <span
                                class="text-4xl font-bold tracking-tight text-gray-900"
                                >${{ tier.price[frequency.value] }}</span
                            >
                            <span
                                class="text-sm font-semibold leading-6 text-gray-600"
                                >{{ frequency.priceSuffix }}</span
                            >
                        </p>
                        <button
                            @click="add2Cart(tier)"
                            :aria-describedby="tier.id"
                            :disabled="$page.props.user === null"
                            :class="[
                                tier.mostPopular
                                    ? 'bg-sky-400 text-white shadow-sm hover:bg-sky-300'
                                    : 'text-sky-400 ring-1 ring-inset ring-sky-200 hover:ring-sky-300',
                                $page.props.user === null
                                    ? 'cursor-not-allowed'
                                    : '',
                                'w-full relative cursor-pointer mt-6 block rounded-md py-2 px-3 text-center text-sm font-semibold leading-6 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600',
                            ]"
                        >
                            <p v-if="$page.props.user === null">
                                <template v-if="langtype === 'US'"> Login to shop </template>
                                <template v-else-if="langtype === 'ES'"> Iniciar sesión para comprar </template>
                                <template v-else-if="langtype === 'PT'"> Faça login para comprar </template>
                                <template v-else-if="langtype === 'FR'"> Connectez-vous pour acheter </template>
                            </p>
                            <p v-else>
                                <template v-if="langtype === 'US'"> Add to cart </template>
                                <template v-else-if="langtype === 'ES'"> Agregar al carrito </template>
                                <template v-else-if="langtype === 'PT'"> Adicionar ao carrinho </template>
                                <template v-else-if="langtype === 'FR'"> Ajouter au panier </template>
                            </p>
                        </button>
                        <ul
                            role="list"
                            class="mt-8 space-y-3 text-sm leading-6 text-gray-600"
                        >
                            <li
                                v-for="(feature, index) in tier.features"
                                :key="feature"
                                class="flex gap-x-3"
                            >
                                <CheckIcon
                                    class="h-6 w-5 flex-none text-sky-400"
                                    aria-hidden="true"
                                />
                                <template v-if="index !== 2">
                                    {{ feature }}
                                </template>
                                <template v-if="index === 2">
                                    <span
                                        class="inline-flex items-center rounded-md bg-purple-400/10 px-2 py-1 text-xs font-medium text-purple-400 ring-1 ring-inset ring-purple-400/30"
                                    >
                                        <template v-if="langtype == 'US'"
                                            >Exclusive</template
                                        >
                                        <template v-else-if="langtype == 'ES'"
                                            >Exclusivo</template
                                        >
                                        <template v-else-if="langtype == 'PT'"
                                            >Exclusivo</template
                                        >
                                        <template v-else-if="langtype == 'FR'"
                                            >Exclusif</template
                                        >
                                    </span>
                                    <p
                                        class="animate-text bg-gradient-to-r from-teal-500 via-purple-500 to-orange-500 bg-clip-text text-transparent font-black my-auto"
                                    >
                                        {{ feature }}
                                    </p>
                                </template>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>
