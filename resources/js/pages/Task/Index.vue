<script setup lang="ts">
import { Form, Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import TaskController from '@/actions/App/Http/Controllers/TaskController';
import TypeController from '@/actions/App/Http/Controllers/TypeController';
import Modal from '@/components/Modal.vue';
import AppLayout from '@/layouts/AppLayout.vue';




const props = defineProps({
    tasks: {
        type: Object,
        required: true
    },
    types: {
        type: Object,
        required: true
    }

});

const deleteTask = (id: number) => {
    if (confirm('Are you sure you want to Delete the Task?')) {
        router.delete(TaskController.destroy(id).url);
    }
}

// const updateStatus = (id: number, event: Event) => {
//     const target = event.target as HTMLSelectElement;
//     const value = target.value;

//     if(confirm('Are you sure you want to Update the Status?')){
//          router.patch(`/tasks/${id}/status`, {
//         status: value
//         });
//     }

//     router.reload({only: ['task']});

// }

const updateStatus = (id: number, status: string) => {
    // const target = event.target as HTMLSelectElement;
    // const value = target.value;

    if (confirm('Are you sure you want to Update the Status?')) {
        router.patch(`/tasks/${id}/status`, {
            status: status
        });
    }else{
        router.reload({ only: ['tasks'] });
    // router.reload
    }

    
}



const handleSuccess = () => {
    const popover = document.getElementById('createmodal') as HTMLElement
    const popover2 = document.getElementById('editmodal') as HTMLElement
    popover.hidePopover();
    popover2.hidePopover();
    window.location.reload();

}


 

//Submit

//Save to a variable
const selectedTask = ref();


//Get What Task to Edit
const editTask = (id: number) => {
    const task = props.tasks.find((task) =>
        task.id === id
    );
    //Bind the task to Form
    selectedTask.value = task;

}


</script>
<template>
    <AppLayout>
        <div class="flex flex-col bg-gray-50 ">
            <div class="bg-blue flex justify-between bg-slate-200 h-20 p-5 items-center">
                <Link :href="TaskController.dashboard().url">
                    <h1 class="text-3xl font-extrabold font-serif">To Do List</h1>
                </Link>
                <div class="flex gap-3">
                    <div class="bg-blue-300 w-30 h-10 rounded-2xl flex justify-center items-center">
                        <!-- <Link :href="TaskController.create().url">
                            ADD Task
                        </Link> -->
                        <button popovertarget="createmodal">
                            ADD Task
                        </button>
                    </div>
                    <div class="bg-blue-300 w-30 h-10 rounded-2xl flex justify-center items-center">
                        <!-- <Link :href="TypeController.created().url">
                            ADD Type
                        </Link> -->
                        <button popovertarget="createdmodal">
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
            <div class="p-3">
                <h1 class="text-2xl">Pending Tasks</h1>

                <table class="min-w-full border justify-center text-center shadow-xl">
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
                        <tr v-for="tsk in props.tasks.filter(t => t.status === 'pending')" :key="tsk.id" class="h-15">
                            <td>{{ tsk.task }}</td>
                            <td>
                                <span v-for="typ in tsk.types" :key="typ.id">
                                    {{ typ.type }}
                                </span>
                            </td>
                            <td>{{ tsk.due }}</td>
                            <td class=" p-2">
                                <!-- <select :value="tsk.status" @change="updateStatus(tsk.id, $event)" :class="[
                                    'text-white p-2', tsk.status === 'completed' ? 'bg-green-500' : 'bg-orange-500'
                                ]">
                                    <option value="pending">Pending</option>
                                    <option value="completed">Completed</option>
                                </select> -->

                                <select v-model="tsk.status" @change="updateStatus(tsk.id, tsk.status)" :class="[
                                    'text-white p-2', tsk.status === 'completed' ? 'bg-green-500' : 'bg-orange-500'
                                ]">
                                    <option value="pending">Pending</option>
                                    <option value="completed">Completed</option>
                                </select>

                            </td>
                            <td>
                                <div class="flex gap-4 justify-center">
                                    <!-- <Link :href="TaskController.edit(tsk.id)">
                                        <button class="bg-blue-300 w-20 h-10 rounded-xl" >
                                            Edit
                                        </button>
                                    </Link> -->
                                    <button @click="editTask(tsk.id)" class="bg-blue-300 w-20 h-10 rounded-xl"
                                        popovertarget="editmodal">
                                        Edit
                                    </button>
                                    <button type="button" @click="deleteTask(tsk.id)"
                                        class="bg-red-500 w-20 h-10 rounded-xl">
                                        Delete
                                    </button>
                                </div>

                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="p-3">
                <h1 class="text-2xl">Completed Tasks</h1>
                <table class="min-w-full border justify-center text-center shadow-xl">
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
                        <tr v-for="tsk in props.tasks.filter(t => t.status === 'completed')" :key="tsk.id" class="h-15">
                            <td>{{ tsk.task }}</td>
                            <td>
                                <span v-for="typ in tsk.types" :key="typ.id">
                                    {{ typ.type }}
                                </span>
                            </td>
                            <td>{{ tsk.due }}</td>
                            <td class=" p-2">
                                <!-- <select :value="tsk.status" @change="updateStatus(tsk.id, $event)" :class="[
                                    'text-white p-2', tsk.status === 'completed' ? 'bg-green-500' : 'bg-orange-500'
                                ]">
                                    <option value="pending">Pending</option>
                                    <option value="completed">Completed</option>
                                </select> -->
                                <select v-model="tsk.status" @change="updateStatus(tsk.id, tsk.status)" :class="[
                                    'text-white p-2', tsk.status === 'completed' ? 'bg-green-500' : 'bg-orange-500'
                                ]">
                                    <option value="pending">Pending</option>
                                    <option value="completed">Completed</option>
                                </select>
                            </td>
                            <td>
                                <div class="flex gap-4 justify-center">

                                    <button class="bg-blue-300 w-20 h-10 rounded-xl"
                                        popovertarget="editmodal" @click="editTask(tsk.id)" >
                                        Edit
                                    </button>

                                    <!-- <button class="bg-blue-300 w-20 h-10 rounded-xl" @click="showTaskEdit = true">
                                        Edit
                                    </button> -->
                                    <button type="button" @click="deleteTask(tsk.id)"
                                        class="bg-red-500 w-20 h-10 rounded-xl">
                                        Delete
                                    </button>
                                </div>

                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <Modal id="createmodal">
                <Form v-bind="TaskController.store.form()" reset-on-success @success="handleSuccess">
                    <div class="flex flex-col items-center gap-5">
                        <label for="task" class="text-2xl">Add New Task</label>
                        <input type="text" name="task" class="border p-2 border-gray-300 h-10 w-50">
                        <select name="type_ids[]" id="" class="h-10 w-50 border border-gray-300">
                            <option value="">select type</option>
                            <option :value="t.id" v-for="t in props.types" :key="t.id">
                                {{ t.type }}
                            </option>
                        </select>
                        <input type="date" name="due" class="h-10 w-50 border border-gray-300 ">
                        <button type="submit" class="bg-blue-300 w-30 h-10 rounded-2xl">Submit</button>
                    </div>
                </Form>
            </Modal>
            <Modal id="createdmodal">
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
            </Modal>

            <Modal id="editmodal">
                <template v-if="selectedTask">
                    <Form v-bind="TaskController.update.form(selectedTask.id)" @success="handleSuccess" reset-on-success >
                        <div class="flex flex-col items-center gap-5">
                            <label for="task" class="text-2xl">Edit Task</label>
                            <input :defaultValue="selectedTask.task" type="text" name="task"
                                class="border border-gray-300 h-10 w-50">
                            <select name="type_ids[]" id="" class="h-10 w-50 border border-gray-300">
                                <option value="">select type</option>
                                <option :value="t.id" v-for="t in props.types" :key="t.id"
                                    :selected="selectedTask.types.some(w => w.id === t.id)">
                                    {{ t.type }}
                                </option>
                            </select>
                            <input :defaultValue="selectedTask.due" type="date" name="due"
                                class="h-10 w-50 border border-gray-300 ">
                            <button type="submit" class="bg-blue-300 w-30 h-10 rounded-2xl">Edit</button>
                        </div>
                    </Form>
                </template>
            </Modal>
        </div>
    </AppLayout>

</template>