<template>
    <div id="telegram">
        <template v-if="telegramData">
            <div>telegram:</div>
            <div><b>name:</b> {{ getName() }};</div>
            <div><b>bio:</b> {{ telegramData.bio ?? '&mdash;' }}.</div>
        </template>
        <template v-else>telegram: &mdash;</template>
    </div>
</template>

<script setup>
const props = defineProps({
    telegramData: {
        required: false,
        default: null,
    }
})

const getName = () => {
    if (!props.telegramData.first_name && !props.telegramData.last_name) {
        return '&mdash;'
    }

    return `${props.telegramData.first_name} ${props.telegramData.last_name}`.trim();
}
</script>
