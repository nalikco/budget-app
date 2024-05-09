<script lang="ts" setup>
import {router, usePage} from "@inertiajs/vue3";
import {telegramService} from "../services";

const page = usePage();
router.post(page.props.auth.route, {
    init_data: telegramService.getInitData(),
});
</script>

<template>
    <div v-if="page.props.errors.init_data === undefined">
        Загрузка...
    </div>
    <div v-if="page.props.errors.init_data !== undefined">
        {{ page.props.errors.init_data }}
    </div>
</template>
