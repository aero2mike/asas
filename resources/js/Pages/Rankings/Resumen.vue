<script>
import { defineComponent } from "vue";
export default defineComponent({
    layout: RankingLayout,
});
</script>

<script setup>
import { defineComponent, onMounted, ref } from "vue";
import RankingLayout from "@/Layouts/RankingLayout.vue";
import RankingCard from "@/Components/RankingCard.vue";
import { Head, usePage } from "@inertiajs/vue3";

const woe_player = usePage().props.woe_player ?? 'N/A';
const pvp_player = usePage().props.pvp_player ?? 'N/A';
const woe_damage = usePage().props.woe_damage ?? 'N/A';
const mvp_player = usePage().props.mvp_player ?? 'N/A';
const cash_player = usePage().props.cash_points ?? 'N/A';
const bg_player = usePage().props.bg_player ?? 'N/A';
</script>

<template>
        <Head :title="'Ranking Resumen'" />
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="overflow-hidden shadow-sm sm:rounded-lg mt-30">
                    <div class="min-h-screen py-8">
                        <div
                            class="mb-5 p-5 py-12 flex flex-wrap flex-row justify-around w-full"
                        >
                            <div class="flex w-full justify-around mb-8">
                                <ranking-card
                                    :title="'Guild vs Guild 🗡'"
                                    :char_name="woe_damage.gname"
                                    :guild_name="woe_damage.master"
                                    :guild_id="woe_damage.guild_id"
                                    :score="woe_damage.comp_kd"
                                    :type="'woe_damage'"
                                    :bg="'bg-woe-damage'"
                                />
                                <ranking-card
                                    :title="'Best WoE Player 🥇'"
                                    :char_name="woe_player.name"
                                    :guild_name="woe_player.GName"
                                    :guild_id="woe_player.guild_id"
                                    :score="woe_player.score"
                                    :type="'guild'"
                                    :bg="'bg-woe'"
                                />
                                <ranking-card
                                    :title="'Best BG Player 🛡'"
                                    :char_name="bg_player.name"
                                    :guild_name="bg_player.GName"
                                    :guild_id="bg_player.guild_id"
                                    :score="bg_player.score"
                                    :type="'battleground'"
                                    :bg="'bg-pvp'"
                                />
                            </div>
                            <div class="flex w-full justify-around">
                                <ranking-card
                                    :title="'MvP Hunter 🏹'"
                                    :char_name="mvp_player.name"
                                    :guild_name="mvp_player.GName"
                                    :guild_id="mvp_player.guild_id"
                                    :score="mvp_player.mvp_kills"
                                    :type="'mvp'"
                                    :bg="'bg-pvp'"
                                />
                                <ranking-card
                                    :title="'Cash Collector 💰'"
                                    :char_name="cash_player.name"
                                    :guild_name="cash_player.GName"
                                    :guild_id="cash_player.guild_id"
                                    :score="cash_player.points"
                                    :type="'cash'"
                                    :bg="'bg-pvp'"
                                />
                                <ranking-card
                                    :title="'PvP Killer ⚔'"
                                    :char_name="pvp_player.name"
                                    :guild_name="pvp_player.GName"
                                    :guild_id="pvp_player.guild_id"
                                    :score="pvp_player.elo"
                                    :type="'pvp'"
                                    :bg="'bg-pvp'"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</template>
