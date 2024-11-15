<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import axios from "axios";
// CKEditor
import ClassicEditor from "@ckeditor/ckeditor5-editor-classic/src/classiceditor";
import EssentialsPlugin from "@ckeditor/ckeditor5-essentials/src/essentials";
import BoldPlugin from "@ckeditor/ckeditor5-basic-styles/src/bold";
import ItalicPlugin from "@ckeditor/ckeditor5-basic-styles/src/italic";
import LinkPlugin from "@ckeditor/ckeditor5-link/src/link";
import ParagraphPlugin from "@ckeditor/ckeditor5-paragraph/src/paragraph";
import FontColorPlugin from "@ckeditor/ckeditor5-font/src/fontcolor";
import BackgroundFontColorPlugin from "@ckeditor/ckeditor5-font/src/fontbackgroundcolor";
import FontSizePlugin from "@ckeditor/ckeditor5-font/src/fontsize";
import HeadingPlugin from "@ckeditor/ckeditor5-heading/src/heading";
import ListPlugin from "@ckeditor/ckeditor5-list/src/list";
import TablePlugin from "@ckeditor/ckeditor5-table/src/table";
import { Alignment } from "@ckeditor/ckeditor5-alignment";
import { BlockQuote } from "@ckeditor/ckeditor5-block-quote";
import {
    Image,
    ImageCaption,
    ImageResize,
    ImageStyle,
    ImageToolbar,
    ImageInsert,
} from "@ckeditor/ckeditor5-image";
import { LinkImage } from "@ckeditor/ckeditor5-link";
import {
    Table,
    TableCellProperties,
    TableProperties,
    TableToolbar,
} from "@ckeditor/ckeditor5-table";
import { Clipboard } from "@ckeditor/ckeditor5-clipboard";
import { PasteFromOffice } from "@ckeditor/ckeditor5-paste-from-office";
import { GeneralHtmlSupport } from "@ckeditor/ckeditor5-html-support";
import { SourceEditing } from "@ckeditor/ckeditor5-source-editing";
// End CKEditor

import { usePage, router } from "@inertiajs/vue3";
import jetButton from "@/Jetstream/Button.vue";
import { reactive } from "vue";
import { notify } from "notiwind";

const wiki_categories = usePage().props.wiki_categories;

const form = reactive({
    title: "",
    slug: "",
    icon: "",
    body: "",
    description: "",
    category_id: 0,
});

const CKEditor_conf = reactive({
    editor: ClassicEditor,
    editorData: "",
    editorConfig: {
        htmlSupport: {
            allow: [
                {
                    name: /.*/,
                    attributes: true,
                    classes: true,
                    styles: true,
                },
            ],
        },
        fontSize: {
            options: [9, 11, 13, "default", 17, 19, 21],
        },
        table: {
            contentTable: {
                style: {
                    "margin-left": "auto",
                    "margin-right": "auto",
                },
            },
            contentToolbar: [
                "tableColumn",
                "tableRow",
                "mergeTableCells",
                "tableProperties",
                "tableCellProperties",
            ],
        },
        fontFamily: {
            options: [
                "default",
                "Ubuntu, Arial, sans-serif",
                "Ubuntu Mono, Courier New, Courier, monospace",
            ],
        },
        plugins: [
            TableProperties,
            TableCellProperties,
            SourceEditing,
            PasteFromOffice,
            GeneralHtmlSupport,
            Clipboard,
            Table,
            TableToolbar,
            FontSizePlugin,
            ImageInsert,
            Image,
            ImageToolbar,
            ImageCaption,
            ImageStyle,
            ImageResize,
            LinkImage,
            BlockQuote,
            Alignment,
            TablePlugin,
            EssentialsPlugin,
            BoldPlugin,
            ItalicPlugin,
            LinkPlugin,
            ParagraphPlugin,
            FontColorPlugin,
            BackgroundFontColorPlugin,
            HeadingPlugin,
            ListPlugin,
        ],
        alignment: {
            options: ["left", "center", "right"],
        },
        toolbar: [
            "heading",
            "|",
            "sourceediting",
            "|",
            "bold",
            "italic",
            "link",
            "|",
            "bulletedList",
            "numberedList",
            "blockQuote",
            "alignment",
            "|",
            "fontColor",
            "fontBackgroundColor",
            "fontSize",
            "|",
            "tableColumn",
            "tableRow",
            "mergeTableCells",
            "insertTable",
            "tableCellProperties",
            "tableProperties",
            "|",
            "imageStyle:block",
            "imageStyle:side",
            "|",
            "toggleImageCaption",
            "imageTextAlternative",
            "|",
            "imageResize",
            "linkImage",
            "insertImage",
            "|",
            "undo",
            "redo",
        ],
        language: "en",
    },
});

const state = reactive({
    title: "",
    message: "",
    group: "",
    duration: 5000,
});

function create_post() {
    form.body = CKEditor_conf.editorData;
    axios
        .post(route("admin.wiki.store", form))
        .then((response) => {
            state.title = "Success";
            state.message = response.data.message;
            state.group = response.data.status;
            notifyMe();
            router.visit(route("admin.wiki.index"));
        })
        .catch((error) => {
            state.title = "Error";
            state.message = error.data.message;
            state.group = error.data.status;
            notifyMe();
        });
}

function notifyMe() {
    notify(
        {
            group: state.group,
            title: state.title.toUpperCase(),
            text: state.message + " ",
        },
        state.duration
    );
}
</script>
<template>
    <admin-layout :title="'Create Wiki Post'">
        <div class="flex flex-wrap">
            <div class="w-full mb-12">
                <div
                    class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded bg-white"
                >
                    <div class="rounded-t mb-0 px-4 py-3 border-0">
                        <div class="flex flex-wrap items-center">
                            <div class="w-full">
                                <div class="flex flex-wrap -mx-3 mb-6">
                                    <div
                                        class="rounded-md w-full px-3 mx-3 pb-1.5 mb-3 pt-2.5 shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-indigo-600"
                                    >
                                        <label
                                            for="post-title"
                                            class="block text-xs font-medium text-gray-900"
                                            >Title</label
                                        >
                                        <input
                                            type="text"
                                            name="post-title"
                                            id="post-title"
                                            v-model="form.title"
                                            class="block w-full border-0 p-0 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6"
                                            placeholder="Post Title"
                                        />
                                    </div>
                                    <div
                                        class="w-full flex items-center px-3 mb-6 md:mb-0"
                                    >
                                        <div
                                            class="rounded-md w-full px-3 pb-1.5 mb-3 pt-2.5 shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-indigo-600"
                                        >
                                            <label
                                                for="post-title"
                                                class="block text-xs font-medium text-gray-900"
                                                >Slug</label
                                            >
                                            <input
                                                type="text"
                                                name="post-slug"
                                                id="post-slug"
                                                v-model="form.slug"
                                                class="block w-full border-0 p-0 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6"
                                                placeholder="https://yourwebsite.com/wiki/example/<your slug>"
                                            />
                                        </div>
                                        <div
                                            class="rounded-md w-full ml-5 px-3 pb-1.5 mb-3 pt-2.5 shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-indigo-600"
                                        >
                                            <label
                                                for="post-icon"
                                                class="block text-xs font-medium text-gray-900"
                                                >Icon SVG</label
                                            >
                                            <input
                                                type="text"
                                                name="post-icon"
                                                id="post-icon"
                                                v-model="form.icon"
                                                class="block w-full border-0 p-0 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6"
                                                placeholder="Icon SVG (https://heroicons.com/)"
                                            />
                                        </div>
                                        <div
                                            class="rounded-md ml-5 text-black w-full px-3 pb-1.5 mb-3 pt-2.5 shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-indigo-600"
                                        >
                                            <select
                                                v-model="form.category_id"
                                                name="post-category"
                                                id="post-category"
                                                class="block w-full border-0 py-2 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-md sm:leading-6"
                                            >
                                                <option
                                                    :value="0"
                                                    selected
                                                    disabled
                                                >
                                                    Select Category
                                                </option>
                                                <option
                                                    :value="wiki_category.id"
                                                    v-for="wiki_category in wiki_categories"
                                                >
                                                    {{ wiki_category.name }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex flex-wrap -mx-3 mb-6">
                                    <div class="w-full px-3">
                                        <label
                                            class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                            for="form-description"
                                        >
                                            Description (MAX 160)
                                        </label>
                                        <textarea
                                            v-model="form.description"
                                            name="form-description"
                                            id="form-description"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                        />
                                        <p class="text-gray-600 text-xs italic">
                                            Make it as long and as crazy as
                                            you'd like
                                        </p>
                                    </div>
                                </div>
                                <div class="w-full">
                                    <jet-button @click="create_post()"
                                        >Create Post</jet-button
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="block w-full px-3 py-2">
                        <ck-editor
                            @input="CKEditor_conf.editorData = $event"
                            :editor="CKEditor_conf.editor"
                            :config="CKEditor_conf.editorConfig"
                        />
                    </div>
                </div>
            </div>
        </div>
    </admin-layout>
</template>
