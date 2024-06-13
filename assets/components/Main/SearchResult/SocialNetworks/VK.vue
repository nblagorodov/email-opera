<template>
    <div id="vk">
        <template v-if="vkData">
            <div>vk:</div>
            <div><b>name:</b> {{ getName() }};</div>
            <div><b>date of birth:</b> {{ vkData.birth_date ?? '&mdash;' }};</div>
            <div><b>status:</b> {{ vkData.status ?? '&mdash;' }};</div>
            <div><b>city:</b> {{ getCountry() }}.</div>
        </template>
        <template v-else>vk: &mdash;</template>
    </div>
</template>

<script setup>
const props = defineProps({
    vkData: {
        required: false,
        default: null,
    }
})

const getName = () => {
    if (!props.vkData.first_name && !props.vkData.last_name) {
        return '&mdash;'
    }

    return `${props.vkData.first_name} ${props.vkData.last_name}`.trim();
}

const getCountry = () => {
    if (!props.vkData.country && !props.vkData.city) {
        return '&mdash;'
    }

    if (!props.vkData.country) {
        return props.vkData.city;
    }

    return `${props.vkData.country}, ${props.vkData.city}`;
}
</script>
