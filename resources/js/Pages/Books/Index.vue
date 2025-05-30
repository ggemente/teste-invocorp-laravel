<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, router } from '@inertiajs/vue3';
import { defineProps, ref } from 'vue';

import { Button } from '@/components/ui/button';
import { Table, TableBody, TableCell, TableCaption, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import { Dialog, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle, DialogClose } from '@/components/ui/dialog';
import { Eye, Pencil, Trash2, MoreHorizontal, BookImage } from 'lucide-vue-next';

const props = defineProps({
    books: Object,
});

const bookToDelete = ref(null);
const showDeleteDialog = ref(false);

const confirmDeleteBook = (book) => {
    bookToDelete.value = book;
    showDeleteDialog.value = true;
};

const deleteBook = () => {
    if (bookToDelete.value) {
        router.delete(route('books.destroy', bookToDelete.value.id), {
            preserveScroll: true,
            onSuccess: () => {
                showDeleteDialog.value = false;
                bookToDelete.value = null;
            }
        });
    }
};

const formatDate = (dateString) => {
    if (!dateString) return '';
    const options = { year: 'numeric', month: '2-digit', day: '2-digit' };
    return new Date(dateString + 'T00:00:00').toLocaleDateString('pt-BR', options);
};
</script>

<template>
    <AppLayout title="Lista de Livros">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold">Lista de Livros</h1>
            <Button asChild>
                <Link :href="route('books.create')">Novo Livro</Link>
            </Button>
        </div>

        <Card>
            <CardContent class="p-0">
                <Table>
                    <TableCaption v-if="books.data.length === 0">Nenhum livro encontrado.</TableCaption>
                    <TableHeader>
                        <TableRow>
                            <TableHead class="w-1/4">Capa</TableHead>
                            <TableHead class="w-1/3">Título</TableHead>
                            <TableHead class="w-1/3">Autor</TableHead>
                            <TableHead>Publicação</TableHead>
                            <TableHead class="text-right">Ações</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-for="book in books.data" :key="book.id">
                            <TableCell>
                                <img v-if="book.cover_image_path" :src="`/storage/${book.cover_image_path}`" :alt="`Capa de ${book.title}`" class="h-16 w-16 object-cover rounded">
                                <div v-else class="h-16 w-16 bg-muted rounded flex items-center justify-center text-muted-foreground">
                                    <BookImage class="h-6 w-6" />
                                </div>
                            </TableCell>
                            <TableCell class="font-medium">
                                <Link :href="route('books.show', book.id)" class="hover:underline text-primary">{{ book.title }}</Link>
                            </TableCell>
                            <TableCell>{{ book.author?.name || 'N/A' }}</TableCell>
                            <TableCell>{{ formatDate(book.publication_date) }}</TableCell>
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
                                            <Link :href="route('books.show', book.id)" class="flex items-center">
                                                <Eye class="mr-2 h-4 w-4" /> Ver
                                            </Link>
                                        </DropdownMenuItem>
                                        <DropdownMenuItem asChild>
                                            <Link :href="route('books.edit', book.id)" class="flex items-center">
                                                <Pencil class="mr-2 h-4 w-4" /> Editar
                                            </Link>
                                        </DropdownMenuItem>
                                        <DropdownMenuItem @click="confirmDeleteBook(book)" class="flex items-center text-destructive hover:!text-destructive focus:!text-destructive">
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

        <div v-if="books.data.length > 0 && books.links.length > 3" class="mt-6 flex justify-center items-center space-x-1">
            <template v-for="(link, key) in books.links" :key="key">
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
                    <DialogDescription v-if="bookToDelete">
                        Tem certeza que deseja excluir o livro "{{ bookToDelete.title }}"? Esta ação não pode ser desfeita.
                    </DialogDescription>
                </DialogHeader>
                <DialogFooter>
                    <DialogClose asChild>
                        <Button variant="outline">Cancelar</Button>
                    </DialogClose>
                    <Button variant="destructive" @click="deleteBook">Excluir</Button>
                </DialogFooter>
            </DialogContent>
        </Dialog>
    </AppLayout>
</template>