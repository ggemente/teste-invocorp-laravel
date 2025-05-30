<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, router } from '@inertiajs/vue3';
import { defineProps } from 'vue';

import { Button } from '@/components/ui/button';
import { Table, TableBody, TableCell, TableCaption, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuTrigger } from '@/components/ui/dropdown-menu'; // Para ações
import { Dialog, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle, DialogTrigger, DialogClose } from '@/components/ui/dialog'; // Para confirmação
import { Eye, Pencil, Trash2, MoreHorizontal } from 'lucide-vue-next';
import { ref } from 'vue';

const props = defineProps({
    authors: Object,
});

const authorToDelete = ref(null);
const showDeleteDialog = ref(false);

const confirmDeleteAuthor = (author) => {
    authorToDelete.value = author;
    showDeleteDialog.value = true;
};

const deleteAuthor = () => {
    if (authorToDelete.value) {
        router.delete(route('authors.destroy', authorToDelete.value.id), {
            preserveScroll: true,
            onSuccess: () => {
                showDeleteDialog.value = false;
                authorToDelete.value = null;
            }
        });
    }
};

</script>

<template>
    <AppLayout title="Lista de Autores">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold">Lista de Autores</h1>
            <Button asChild>
                <Link :href="route('authors.create')">Novo Autor</Link>
            </Button>
        </div>

        <Card>
            <CardContent class="p-0">
                <Table>
                    <TableCaption v-if="authors.data.length === 0">Nenhum autor encontrado.</TableCaption>
                    <TableHeader>
                        <TableRow>
                            <TableHead class="w-[300px]">Nome</TableHead>
                            <TableHead>Status</TableHead>
                            <TableHead>Livros</TableHead>
                            <TableHead class="text-right">Ações</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-for="author in authors.data" :key="author.id">
                            <TableCell class="font-medium">
                                <Link :href="route('authors.show', author.id)" class="hover:underline text-primary">{{ author.name }}</Link>
                            </TableCell>
                            <TableCell>
                                <span v-if="author.status === 'active'" class="px-2 py-1 text-xs font-medium text-green-700 bg-green-100 rounded-full">Ativo</span>
                                <span v-else class="px-2 py-1 text-xs font-medium text-red-700 bg-red-100 rounded-full">Inativo</span>
                            </TableCell>
                            <TableCell>{{ author.books_count }}</TableCell>
                            <TableCell class="text-right">
                                <DropdownMenu>
                                    <DropdownMenuTrigger asChild>
                                        <Button variant="ghost" class="h-8 w-8 p-0">
                                            <span class="sr-only">Abrir menu</span>
                                            <MoreHorizontal class="h-4 w-4" />
                                        </Button>
                                    </DropdownMenuTrigger>
                                    <DropdownMenuContent align="end">
                                        <DropdownMenuItem asChild>
                                            <Link :href="route('authors.show', author.id)" class="flex items-center">
                                                <Eye class="mr-2 h-4 w-4" /> Ver
                                            </Link>
                                        </DropdownMenuItem>
                                        <DropdownMenuItem asChild>
                                            <Link :href="route('authors.edit', author.id)" class="flex items-center">
                                                <Pencil class="mr-2 h-4 w-4" /> Editar
                                            </Link>
                                        </DropdownMenuItem>
                                        <DropdownMenuItem @click="confirmDeleteAuthor(author)" class="flex items-center text-destructive hover:!text-destructive focus:!text-destructive">
                                            <Trash2 class="mr-2 h-4 w-4" /> Excluir
                                        </DropdownMenuItem>
                                    </DropdownMenuContent>
                                </DropdownMenu>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </CardContent>
        </Card>

        <div v-if="authors.data.length > 0 && authors.links.length > 3" class="mt-6 flex justify-center items-center space-x-1">
            <template v-for="(link, key) in authors.links" :key="key">
                <Button asChild :variant="link.active ? 'default' : 'outline'" size="sm" :disabled="!link.url">
                    <Link v-if="link.url" :href="link.url" v-html="link.label" />
                    <span v-else v-html="link.label" class="cursor-default opacity-50"></span>
                </Button>
            </template>
        </div>

        <Dialog :open="showDeleteDialog" @update:open="showDeleteDialog = $event">
            <DialogContent>
                <DialogHeader>
                    <DialogTitle>Confirmar Exclusão</DialogTitle>
                    <DialogDescription v-if="authorToDelete">
                        Tem certeza que deseja excluir o autor "{{ authorToDelete.name }}"?
                        <span v-if="authorToDelete.books_count > 0" class="block text-destructive mt-2">
                            AVISO: Este autor possui {{ authorToDelete.books_count }} livro(s) associado(s). A exclusão pode falhar se não for permitida.
                        </span>
                        Esta ação não pode ser desfeita.
                    </DialogDescription>
                </DialogHeader>
                <DialogFooter>
                    <DialogClose asChild>
                        <Button variant="outline">Cancelar</Button>
                    </DialogClose>
                    <Button variant="destructive" @click="deleteAuthor">Excluir</Button>
                </DialogFooter>
            </DialogContent>
        </Dialog>

    </AppLayout>
</template>