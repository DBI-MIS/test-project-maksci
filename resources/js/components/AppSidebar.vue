<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { BookOpen, CheckCheck, ClipboardList, FolderGit2, LayoutGrid, LayoutList, MousePointer2, NotebookTabs, Plus } from 'lucide-vue-next';
import AppLogo from '@/components/AppLogo.vue';
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import { dashboard } from '@/routes';
import task from '@/routes/task';
import type from '@/routes/type';
import type { NavItem } from '@/types';
import tasks from '@/routes/tasks';

const mainNavItems: NavItem[] = [
    // {
    //     title: 'Dashboard',
    //     href: dashboard(),
    //     icon: LayoutGrid,
    // },
    {
        title: 'Dashboard',
        href: task.dashboard(),
        icon: LayoutGrid,
    },
    {
        title: 'All Task',
        href: task.index(),
        icon: ClipboardList,
    },
    // {
    //     title: 'Add Task',
    //     href: task.create(),
    //     icon: Plus,
    // },
    // {
    //     title: 'Display All Tasks',
    //     href: dashboard(),
    //     icon: LayoutGrid,
    // },
    {
        title: 'To Do Types',
        href: type.index(),
        icon: MousePointer2,
    },
    // {
    //     title: 'Pending Tasks',
    //     href: task.pending(),
    //     icon: LayoutList,
    // },
    // {
    //     title: 'Completed Tasks',
    //     href: task.completed(),
    //     icon: CheckCheck,
    // },
    
];

const footerNavItems: NavItem[] = [
    {
        title: 'Repository',
        href: 'https://github.com/laravel/vue-starter-kit',
        icon: FolderGit2,
    },
    {
        title: 'Documentation',
        href: 'https://laravel.com/docs/starter-kits#vue',
        icon: BookOpen,
    },
];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="task.dashboard()">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
