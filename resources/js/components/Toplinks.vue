<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import TaskController from '@/actions/App/Http/Controllers/TaskController';

</script>
<template>
    <div class="flex ">
        <div class="flex gap-3">
            <div class="bg-blue-300 w-30 h-10 rounded-2xl flex justify-center items-center">
                <button popovertarget="createmodal"
                    class="bg-blue-300 w-30 h-10 rounded-2xl flex justify-center items-center">
                    ADD Task
                </button>
            </div>
            <div class="bg-blue-300 w-30 h-10 rounded-2xl flex justify-center items-center">
                <button popovertarget="createdmodal"
                    class="bg-blue-300 w-30 h-10 rounded-2xl flex justify-center items-center">
                    ADD Type
                </button>
            </div>
            <div class="bg-blue-300 w-30 h-10 rounded-2xl flex justify-center items-center">
                <Link :href="TaskController.index().url">
                    Show Tasks
                </Link>
            </div>
        </div>
    </div>
</template>