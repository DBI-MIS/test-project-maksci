<script setup lang="ts">

const props = defineProps({
    histories:{
        type:Object,
        required:true
    }
})
</script>
<template>
    <div>
      <template v-for="history in props.histories" :key="history.id">
        <span>{{ history.action }}</span>
      </template>
    </div>
</template>