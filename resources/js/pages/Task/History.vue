<script setup lang="ts">

const props = defineProps({
    history:{
        type:Object,
        required:true
    }
})
</script>
<template>
    <div>
        {{ props.history.action }}
    </div>
</template>