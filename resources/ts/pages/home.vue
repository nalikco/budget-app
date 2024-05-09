<script lang="ts" setup>
import {usePage} from "@inertiajs/vue3";
import AppWrapper from "../app-wrapper.vue";

const page = usePage();

</script>

<template>
    <AppWrapper>
        hello, {{ page.props.auth.user.username }}
    </AppWrapper>
</template>
