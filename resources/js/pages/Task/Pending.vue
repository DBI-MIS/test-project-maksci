<script setup lang="ts">
import { Link, router } from '@inertiajs/vue3';
import { computed } from 'vue';
import TaskController from '@/actions/App/Http/Controllers/TaskController';
import AppLayout from '@/layouts/AppLayout.vue';
import TypeController from '@/actions/App/Http/Controllers/TypeController';


const props = defineProps({
    task: {
        type: Object,
        required: true
    },

});

const deleteTask = (id: number) => {
    router.delete(TaskController.destroy(id).url);
}

const updateStatus = (id: number, status: string) => {
    router.patch(`/tasks/${id}/status`, {
        status: status
    })
}

//const pendingTasks = computed(() => props.task.filter(t => t.status === 'pending'));
const pendingTasks = computed(() => {
    // Ensure props.task is an array
    return Array.isArray(props.task)
        ? props.task.filter(t => t.status === 'pending')
        : [];
});

</script>
<template>
    <AppLayout>
        <div>
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
                <div class="p-3">
                    <table class="min-w-full border justify-center text-center shadow-xl ">
                        <thead>
                            <tr class="bg-mist-100 h-20">
                                <th>Task</th>
                                <th>Type</th>
                                <th>Due Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="tsk in pendingTasks" :key="tsk.id" class="h-15">
                                <td>{{ tsk.task }}</td>
                                <td>
                                    <span v-for="typ in tsk.types" :key="typ.id">
                                        {{ typ.type }}
                                    </span>
                                </td>
                                <td>{{ tsk.due }}</td>
                                <td class="p-2">
                                    <select :value="tsk.status" @change="updateStatus(tsk.id, $event.target.value)" :class="[
                                    'text-white p-2', tsk.status === 'completed' ? 'bg-green-500' : 'bg-orange-500' 
                                ]" >
                                        <option value="pending">Pending</option>
                                        <option value="completed">Completed</option>
                                    </select>
                                </td>
                                <td>
                                    <div class="flex gap-4 justify-center">
                                    <Link :href="TaskController.edit(tsk.id)">
                                        <button class="bg-blue-300 w-20 h-10 rounded-xl">
                                            Edit
                                        </button>
                                    </Link>
                                    <button type="button" @click="deleteTask(tsk.id)" class="bg-red-500 w-20 h-10 rounded-xl">
                                        Delete
                                    </button>
                                </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>

        </div>
    </AppLayout>

</template>