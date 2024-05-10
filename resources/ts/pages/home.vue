<script lang="ts" setup>
import { usePage } from '@inertiajs/vue3';
import AppWrapper from '../app-wrapper.vue';
import UserData = App.Dto.User.UserData;

const page = usePage<{
    auth: {
        user: UserData;
    };
}>();
</script>

<template>
    <AppWrapper> hello, {{ page.props.auth.user.username }}</AppWrapper>
</template>
