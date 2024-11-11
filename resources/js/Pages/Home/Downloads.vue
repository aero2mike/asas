<script>
import GuestLayout from "@/Layouts/GuestLayout.vue";

export default {
    layout: GuestLayout,
};
</script>

<script setup>
import { onMounted, ref } from "vue";
import { Head } from "@inertiajs/vue3";
const lang = ref(localStorage.getItem("lang") || "US");
function redirect_download(type) {
    var url = "";
    switch (type) {
        case "mega":
            url =
                "https://mega.nz/file/MDJkVLhL#1ZZnQbOMMWmNqg5omuT6kZT1oTx0hXlfYZL22RSE4nc";
            break;
        case "mediafire":
            url =
                "https://www.mediafire.com/file/n1f07ajxdir3fi4/Rise+of+Valhalla+-+February.zip/file";
            break;
        case "drive":
            url =
                "https://drive.google.com/file/d/1GMwoM7JCEZqyQ6mEXtk7wXZznzwZc6P0/view?usp=sharing";
            break;
    }
    window.open(url, "_blank");
}

onMounted(() => {
    lang.value = localStorage.getItem("lang") || "US";

});
</script>

<template>
    <Head :title="'Downloads'" />

    <div
        class="antialiased w-full md:w-10/12 h-full text-gray-400 font-inter p-10 mx-auto text-xl"
    >
        <div class="container w-full p-6 mx-auto md:mt-36 text-black">
            <div class="flex flex-col items-center">
                <div id="title" class="text-center">
                    <h1
                        v-if="lang == 'US'"
                        class="mt-10 text-4xl font-bold tracking-tight text-black sm:text-5xl drop-shadow mb-5"
                    >
                        Downloads
                    </h1>
                    <h1
                        v-if="lang == 'ES'"
                        class="mt-10 text-4xl font-bold tracking-tight text-black sm:text-5xl drop-shadow mb-5"
                    >
                        Descargas
                    </h1>
                    <h1
                        v-if="lang == 'PT'"
                        class="mt-10 text-4xl font-bold tracking-tight text-black sm:text-5xl drop-shadow mb-5"
                    >
                        Baixar
                    </h1>
                    <h1
                        v-if="lang == 'FR'"
                        class="mt-10 text-4xl font-bold tracking-tight text-black sm:text-5xl drop-shadow mb-5"
                    >
                        Télécharger
                    </h1>
                    
                    <img src="/img/logo-light.png" alt="" class="mx-auto" />

                    <p class="page-text text-center px-5 py-4 mt-5"
                        v-if="lang == 'US'"
                    >
                        Steps to downloading it's easy as one, two, three. The
                        download links are made separately depending on the
                        files that you currently have in your computer. To
                        prevent patching problems and errors, we suggest that
                        you download the full installer using the most
                        convenient download mirror for you.
                    </p>
                    <p class="page-text text-center px-5 py-4 mt-5"
                        v-if="lang == 'ES'"
                    >
                        Los pasos para descargar son fáciles como uno, dos,
                        tres. Los enlaces de descarga se realizan por separado
                        dependiendo de los archivos que tenga actualmente en su
                        computadora. Para evitar problemas y errores de
                        parcheo, le sugerimos que descargue el instalador
                        completo utilizando el espejo de descarga más
                        conveniente para usted.
                    </p>
                    <p class="page-text text-center px-5 py-4 mt-5"
                        v-if="lang == 'PT'"
                    >
                        Os passos para baixar são fáceis como um, dois, três. Os
                        links de download são feitos separadamente, dependendo
                        dos arquivos que você tem atualmente em seu computador.
                        Para evitar problemas e erros de patch, sugerimos que
                        você baixe o instalador completo usando o utilizando a opção de download 
                        mais conveniente para você.
                    </p>
                    <p class="page-text text-center px-5 py-4 mt-5"
                        v-if="lang == 'FR'"
                    >
                        Les étapes pour télécharger sont aussi simples que un,
                        deux, trois. Les liens de téléchargement sont créés
                        séparément en fonction des fichiers que vous avez
                        actuellement sur votre ordinateur. Pour éviter les
                        problèmes et les erreurs de patch, nous vous suggérons
                        de télécharger l'installateur complet en utilisant le
                        miroir de téléchargement le plus pratique pour vous.
                    </p>
                </div>

                <div class="w-full w-full md:w-10/12 z-10">
                    <div
                        class="pt-6 flex items-center justify-center flex-wrap"
                    >
                        <div
                            @click="redirect_download('mega')"
                            class="w-full sm:mb-5 md:w-1/5 lg:w-1/4 lg:p-5 rounded-md text-center flex items-center justify-center text-2xl font-semibold hover:bg-red-500/90 bg-gray-50 hover:shadow-lg md:mr-5 cursor-pointer mb-2"
                        >
                            <div class="class flex flex-col items-center">
                                <img class="" src="/img/mega.png" alt="" />

                                MEGA
                            </div>
                        </div>
                        <div
                            @click="redirect_download('mediafire')"
                            class="w-full sm:mb-5 md:w-1/5 lg:w-1/4 lg:p-5 rounded-md text-center flex items-center justify-center text-2xl font-semibold hover:bg-sky-500/80 bg-gray-50 hover:shadow-lg md:mr-5 cursor-pointer mb-2"
                        >
                            <div class="class flex flex-col items-center">
                                <img class="" src="/img/mediafire.png" alt="" />

                                MEDIAFIRE
                            </div>
                        </div>

                        <div
                            @click="redirect_download('drive')"
                            class="w-full sm:mb-5 md:w-1/5 lg:w-1/4 lg:p-5 rounded-md text-center flex items-center justify-center text-2xl font-semibold hover:bg-yellow-400/80 bg-gray-50 hover:shadow-lg md:mr-5 cursor-pointer mb-2"
                        >
                            <div class="class flex flex-col items-center">
                                <img
                                    class=""
                                    src="/img/google_drive.png"
                                    alt=""
                                />

                                DRIVE
                            </div>
                        </div>
                        <div class="flex flex-col items-center justify-center">
                            <img src="" alt="" />
                            <div class="H-FULL">
                                <i
                                    class="fas fa-exclamation-triangle"
                                    style="
                                        font-size: 1.5em;
                                        padding-right: 0.5em;
                                    "
                                ></i>
                                <h2
                                    v-if="lang == 'US'"
                                    class="underline text-2xl text-black mb-5 font-bold text-center"
                                >
                                    Experiencing other problems?
                                </h2>
                                <h2
                                    v-if="lang == 'ES'"
                                    class="underline text-2xl text-black mb-5 font-bold text-center"
                                >
                                    ¿Experimentando otros problemas?
                                </h2>
                                <h2
                                    v-if="lang == 'PT'"
                                    class="underline text-2xl text-black mb-5 font-bold text-center"
                                >
                                Teve algum problema?
                                </h2>
                                <h2
                                    v-if="lang == 'FR'"
                                    class="underline text-2xl text-black mb-5 font-bold text-center"
                                >
                                    Rencontrer d'autres problèmes?
                                </h2>

                                <p class="page-text mb-5"
                                    v-if="lang == 'US'"
                                >
                                    Join our <strong>Discord</strong> and seek
                                    help in our #support channel. We will be
                                    more than happy to help you, so that you can
                                    join us as soon as possible.
                                </p>
                                <p class="page-text mb-5"
                                    v-if="lang == 'ES'"
                                >
                                    Únase a nuestro <strong>Discord</strong> y
                                    busque ayuda en nuestro canal #support.
                                    Estaremos más que felices de ayudarlo, para
                                    que pueda unirse a nosotros lo antes
                                    posible.
                                </p>
                                <p class="page-text mb-5"
                                    v-if="lang == 'PT'"
                                >
                                    Junte-se ao nosso <strong>Discord</strong>
                                    e procure ajuda em nosso canal #support.
                                    Teremos o maior prazer em ajudá-lo, para
                                    que você possa se juntar a nós o mais
                                    rápido possível.
                                </p>
                                <p class="page-text mb-5"
                                    v-if="lang == 'FR'"
                                >
                                    Rejoignez notre <strong>Discord</strong> et
                                    demandez de l'aide dans notre chaîne
                                    #support. Nous serons plus qu'heureux de
                                    vous aider, afin que vous puissiez nous
                                    rejoindre dès que possible.
                                </p>
                            </div>
                            <a
                                href="https://discord.gg/ZqwtPCjS7c"
                                target="”_blank”"
                                data-v-3c0d6e26=""
                                ><img
                                    src="https://discordapp.com/api/guilds/1051301831764090932/widget.png?style=banner2"
                                    class="mx-auto"
                                    data-v-3c0d6e26=""
                            /></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
