<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, router } from '@inertiajs/vue3';
import { defineProps, computed, ref } from 'vue';

import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Dialog, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle, DialogClose } from '@/components/ui/dialog';
import { CalendarDays, BookOpen, AlignLeft, BookImage } from 'lucide-vue-next';

const props = defineProps({
    book: Object,
});

const showDeleteDialog = ref(false);

const coverImageUrl = computed(() => {
    return props.book.cover_image_path ? `/storage/${props.book.cover_image_path}` : null;
});

const formattedPublicationDate = computed(() => {
    if (!props.book.publication_date) return '';
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(props.book.publication_date + 'T00:00:00').toLocaleDateString('pt-BR', options);
});

const deleteBook = () => {
    router.delete(route('books.destroy', props.book.id),{
        onSuccess: () => {
            showDeleteDialog.value = false;
        }
    });
};
</script>

<template>
    <AppLayout :title="`Detalhes do Livro: ${book.title}`">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl lg:text-3xl font-semibold">{{ book.title }}</h1>
            <Button variant="outline" asChild>
                <Link :href="route('books.index')">&larr; Voltar para a lista</Link>
            </Button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="md:col-span-1">
                <Card>
                    <CardHeader>
                        <CardTitle class="flex items-center"><BookImage class="mr-2 h-5 w-5" /> Capa</CardTitle>
                    </CardHeader>
                    <CardContent class="flex justify-center items-center">
                        <img v-if="coverImageUrl" :src="coverImageUrl" :alt="`Capa de ${book.title}`" class="max-h-96 w-auto object-contain rounded-md shadow-lg">
                        <div v-else class="h-64 w-full bg-muted rounded-md flex flex-col items-center justify-center text-muted-foreground">
                            <BookImage class="h-16 w-16 mb-2" />
                            <span>Sem capa</span>
                        </div>
                    </CardContent>
                </Card>
            </div>

            <div class="md:col-span-2 space-y-6">
                <Card>
                    <CardHeader>
                        <CardTitle class="flex items-center"><BookOpen class="mr-2 h-5 w-5" /> Detalhes do Livro</CardTitle>
                    </CardHeader>
                    <CardContent class="space-y-4">
                        <div>
                            <p class="text-sm font-medium text-muted-foreground">Título</p>
                            <p class="text-lg">{{ book.title }}</p>
                        </div>
                        <div v-if="book.author">
                            <p class="text-sm font-medium text-muted-foreground">Autor</p>
                            <Link :href="route('authors.show', book.author.id)" class="text-lg text-primary hover:underline">{{ book.author.name }}</Link>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-muted-foreground">Data de Publicação</p>
                            <p class="text-lg flex items-center"><CalendarDays class="mr-1 h-4 w-4 text-muted-foreground" /> {{ formattedPublicationDate }}</p>
                        </div>
                    </CardContent>
                </Card>

                <Card>
                    <CardHeader>
                        <CardTitle class="flex items-center"><AlignLeft class="mr-2 h-5 w-5" /> Descrição</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <p class="text-foreground/90 leading-relaxed whitespace-pre-wrap">{{ book.description }}</p>
                    </CardContent>
                </Card>
            </div>
        </div>


        <div class="mt-8 flex items-center space-x-2">
            <Button variant="outline" asChild>
                <Link :href="route('books.edit', book.id)">Editar</Link>
            </Button>
            <Dialog v-model:open="showDeleteDialog">
                <DialogTrigger asChild>
                    <Button variant="destructive">Excluir</Button>
                </DialogTrigger>
                <DialogContent>
                    <DialogHeader>
                        <DialogTitle>Confirmar Exclusão</DialogTitle>
                        <DialogDescription>
                            Tem certeza que deseja excluir o livro "{{ book.title }}"? Esta ação não pode ser desfeita.
                        </DialogDescription>
                    </DialogHeader>
                    <DialogFooter>
                        <DialogClose asChild><Button variant="outline">Cancelar</Button></DialogClose>
                        <Button variant="destructive" @click="deleteBook">Excluir</Button>
                    </DialogFooter>
                </DialogContent>
            </Dialog>
        </div>
    </AppLayout>
</template>