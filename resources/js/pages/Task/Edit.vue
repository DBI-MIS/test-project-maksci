<script setup lang="ts">
import { Form, Link } from '@inertiajs/vue3';
import TaskController from '@/actions/App/Http/Controllers/TaskController';
import TypeController from '@/actions/App/Http/Controllers/TypeController';
import AppLayout from '@/layouts/AppLayout.vue';

const props = defineProps({
    task: {
        type: Object,
        required: true
    },
    type: {
        type: Object,
        required: true
    },


});
</script>
<template>
    <AppLayout>
        <!-- <div>
            <Form v-bind="TaskController.update.form(props.task.id)">
                <input :defaultValue="props.task.task" type="text" name="task">
                <select multiple name="type_ids[]" id="">
                    <option value="">select type</option>
                    <option :value="t.id" v-for="t in props.type" :key="t.id"
                        :selected="props.task.types.some(w => w.id === t.id)">
                        {{ t.type }}
                    </option>
                </select>
                <input :defaultValue="props.task.due" type="date" name="due">
                <button class="submit">Submit</button>
            </Form>
        </div> -->
        <div class="flex flex-col bg-gray-50">
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
            <div class="flex flex-col justify-center items-center p-10 bg-gray-50">
                <div class="flex bg-mist-100 justify-center w-100 h-100 p-10 rounded-2xl shadow-xl ">
                    <Form v-bind="TaskController.update.form(props.task.id)">
                        <div class="flex flex-col items-center gap-5">
                            <label for="task" class="text-2xl">Edit Task</label>
                            <input :defaultValue="props.task.task" type="text" name="task"
                                class="border border-gray-300 h-10 w-50">
                            <select name="type_ids[]" id="" class="h-10 w-50 border border-gray-300">
                                <option value="">select type</option>
                                <option :value="t.id" v-for="t in props.type" :key="t.id"
                                    :selected="props.task.types.some(w => w.id === t.id)">
                                    {{ t.type }}
                                </option>
                            </select>
                            <input :defaultValue="props.task.due" type="date" name="due" class="h-10 w-50 border border-gray-300 ">
                            <button type="submit" class="bg-blue-300 w-30 h-10 rounded-2xl">Submit</button>
                        </div>
                    </Form>
                </div>
            </div>
        </div>
    </AppLayout>

</template>