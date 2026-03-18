<script setup lang="ts">

const props = defineProps({
    id: {
        type: String,
        required: true
    }
})

</script>
<template>
    <div :id="props.id" popover class="h-dvh w-dvw backdrop:bg-transparent bg-black/40" >
        <div class="fixed inset-0 flex overflow-y-auto py-2 justify-center items-center" scroll-region @click.self="$el.hidePopover()">
            <div class="z-20 overflow-hidden bg-mist-100 h-100 w-100 flex items-center justify-center rounded-2xl shadow-2xl">
                <slot />
            </div>
        </div>
    </div>
</template>