<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, router } from '@inertiajs/vue3';
import { defineProps, ref } from 'vue';

import { Button } from '@/components/ui/button';
import { Card, CardContent, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';
import { Dialog, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle, DialogClose } from '@/components/ui/dialog';
import { Alert, AlertDescription, AlertTitle } from '@/components/ui/alert';
import { Badge } from '@/components/ui/badge';
import { List, CalendarDays, Info } from 'lucide-vue-next';

const props = defineProps({
    author: Object,
});

const showDeleteDialog = ref(false);

const deleteAuthor = () => {
    router.delete(route('authors.destroy', props.author.id), {
        onFinish: () => {
            showDeleteDialog.value = false;
        }
    });
};

const formatDate = (dateString) => {
    if (!dateString) return '';
    const options = { year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' };
    return new Date(dateString).toLocaleDateString('pt-BR', options);
};

const formatBookPublicationDate = (dateString) => {
    if (!dateString) return '';
    const options = { year: 'numeric', month: '2-digit', day: '2-digit' };
    return new Date(dateString + 'T00:00:00').toLocaleDateString('pt-BR', options);
};
</script>

<template>
    <AppLayout :title="`Detalhes do Autor: ${author.name}`">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl lg:text-3xl font-semibold">{{ author.name }}</h1>
            <Button variant="outline" asChild>
                <Link :href="route('authors.index')">&larr; Voltar para a lista</Link>
            </Button>
        </div>

        <div class="grid gap-6 md:grid-cols-3">
            <Card class="md:col-span-1">
                <CardHeader>
                    <CardTitle>Detalhes do Autor</CardTitle>
                </CardHeader>
                <CardContent class="space-y-4">
                    <div>
                        <p class="text-sm font-medium text-muted-foreground">Nome</p>
                        <p class="text-lg">{{ author.name }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-muted-foreground">Status</p>
                        <Badge :variant="author.status === 'active' ? 'default' : 'destructive'">
                            {{ author.status === 'active' ? 'Ativo' : 'Inativo' }}
                        </Badge>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-muted-foreground">Data de Criação</p>
                        <p class="text-sm">{{ formatDate(author.created_at) }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-muted-foreground">Última Atualização</p>
                        <p class="text-sm">{{ formatDate(author.updated_at) }}</p>
                    </div>
                </CardContent>
                <CardFooter class="flex space-x-2">
                    <Button variant="outline" asChild>
                        <Link :href="route('authors.edit', author.id)">Editar</Link>
                    </Button>
                    <Dialog v-model:open="showDeleteDialog">
                        <DialogTrigger asChild>
                            <Button variant="destructive">Excluir</Button>
                        </DialogTrigger>
                        <DialogContent>
                            <DialogHeader>
                                <DialogTitle>Confirmar Exclusão</DialogTitle>
                                <DialogDescription>
                                    Tem certeza que deseja excluir o autor "{{ author.name }}"?
                                    <span v-if="author.books && author.books.length > 0" class="block text-destructive mt-2">
                                        AVISO: Este autor possui {{ author.books.length }} livro(s) associado(s). A exclusão pode falhar se não for permitida.
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
                </CardFooter>
            </Card>

            <Card class="md:col-span-2">
                <CardHeader>
                    <CardTitle class="flex items-center">
                        <List class="mr-2 h-5 w-5" /> Livros de {{ author.name }}
                    </CardTitle>
                </CardHeader>
                <CardContent>
                    <div v-if="author.books && author.books.length > 0" class="space-y-3">
                        <div v-for="book in author.books" :key="book.id" class="p-3 border rounded-md hover:bg-accent">
                            <Link :href="route('books.show', book.id)" class="font-medium text-primary hover:underline">{{ book.title }}</Link>
                            <p class="text-sm text-muted-foreground flex items-center">
                                <CalendarDays class="mr-1 h-4 w-4" /> Publicado em: {{ formatBookPublicationDate(book.publication_date) }}
                            </p>
                        </div>
                    </div>
                    <Alert v-else variant="info" class="mt-0"> <Info class="h-4 w-4" />
                        <AlertTitle>Nenhum Livro</AlertTitle>
                        <AlertDescription>
                            Este autor ainda não possui livros cadastrados.
                        </AlertDescription>
                    </Alert>
                </CardContent>
            </Card>
        </div>
    </AppLayout>
</template>