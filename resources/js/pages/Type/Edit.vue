<script setup lang="ts">
import { Form, Link } from '@inertiajs/vue3';
import TaskController from '@/actions/App/Http/Controllers/TaskController';
import TypeController from '@/actions/App/Http/Controllers/TypeController';
import AppLayout from '@/layouts/AppLayout.vue';

const props = defineProps({
    type: {
        type: Object,
        required: true
    }
});
</script>
<template>
    <AppLayout>
        <!-- <div>
            <Form v-bind="TypeController.update.form(props.type.id)">
                <input :defaultValue="props.type.type" type="text" name="type">
                <input :defaultValue="props.type.description" type="text" name="description">
                <button class="submit">Submit</button>
            </Form>
        </div> -->
        <div class="flex flex-col">
            <div class="bg-blue flex justify-between bg-slate-200 h-20 p-5 items-center">
                <Link :href="TaskController.dashboard().url">
                    <h1 class="text-3xl font-extrabold font-serif">To Do List</h1>
                </Link>
                <div class="flex gap-3">
                    <div class="bg-blue-300 w-30 h-10 rounded-2xl flex justify-center items-center">
                        <Link :href="TaskController.create()">
                            ADD Task
                        </Link>
                    </div>
                    <div class="bg-blue-300 w-30 h-10 rounded-2xl flex justify-center items-center">
                        <Link :href="TypeController.create()">
                            ADD Type
                        </Link>
                    </div>
                    <div class="bg-blue-300 w-30 h-10 rounded-2xl flex justify-center items-center">
                        <Link :href="TaskController.index()">
                            Show Tasks
                        </Link>
                    </div>
                </div>
            </div>
            <div class="flex flex-col justify-center items-center p-10">
                <div class="flex bg-mist-100 justify-center w-100 h-100 p-10 rounded-2xl shadow-xl">
                    <Form v-bind="TypeController.update.form(props.type.id)">
                        <div class="flex flex-col items-center gap-5">
                            <label for="task" class="text-2xl">Type</label>
                            <input :defaultValue="props.type.type" type="text" name="type"
                                class="border p-2 border-gray-300 h-10">
                            <label for="task" class="text-2xl">Description</label>
                            <input :defaultValue="props.type.description" type="text" name="description"
                                class="border p-2 border-gray-300 h-10">
                            <button type="submit" class="bg-blue-300 w-30 h-10 rounded-2xl">Submit</button>
                        </div>
                    </Form>
                </div>
            </div>
        </div>

    </AppLayout>

</template>