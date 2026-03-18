<script setup lang="ts">
import { Form, Link } from '@inertiajs/vue3';
import TaskController from '@/actions/App/Http/Controllers/TaskController';
import TypeController from '@/actions/App/Http/Controllers/TypeController';
import AppLayout from '@/layouts/AppLayout.vue';


</script>
<template>
    <AppLayout>
        <div class="fixed inset-0 bg-black/50 flex items-center justify-center">
            <div class="bg-blue flex justify-between bg-slate-200 h-20 p-5 items-center">
                <Link :href="TaskController.dashboard().url">
                    <h1 class="text-3xl font-extrabold font-serif">To Do List</h1>
                </Link>
                <div class="flex gap-3">
                    <div class="bg-blue-300 w-30 h-10 rounded-2xl flex justify-center items-center">
                        <Link :href="TaskController.create().url">
                            ADD Task
                        </Link>
                    </div>
                    <div class="bg-blue-300 w-30 h-10 rounded-2xl flex justify-center items-center">
                        <Link :href="TypeController.created().url">
                            ADD Type
                        </Link>
                    </div>
                    <div class="bg-blue-300 w-30 h-10 rounded-2xl flex justify-center items-center">
                        <Link :href="TaskController.index().url">
                            Show Tasks
                        </Link>
                    </div>
                </div>
            </div>
            <div class="flex flex-col justify-center items-center p-10">
                <div class="flex bg-mist-100 justify-center w-100 h-100 p-10 rounded-2xl shadow-xl">
                    <Form v-bind="TypeController.store.form()">
                        <div class="flex flex-col items-center gap-5">
                            <label for="task" class="text-2xl">Create New Type</label>
                            <input type="text" name="type" class="border p-2 border-gray-300 h-10">
                            <label for="task" class="text-2xl">Description</label>
                            <input type="text" name="description" class="border p-2 border-gray-300 h-10">
                            <div class="flex gap-3">
                                <button type="submit" class="bg-blue-300 w-30 h-10 rounded-2xl">Submit</button>
                            </div>
                        </div>
                    </Form>
                </div>
            </div>
        </div>

    </AppLayout>

</template>