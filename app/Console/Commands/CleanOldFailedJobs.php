<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CleanOldFailedJobs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:clean-old-failed-jobs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deleta registros antigos da tabela failed_jobs (mais de 30 dias)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $retentionDays = 30;
        $cutoffDate = Carbon::now()->subDays($retentionDays);

        $this->info('Iniciando limpeza de failed_jobs antigos...');

        try {
            $deletedCount = DB::table('failed_jobs')
                ->where('failed_at', '<=', $cutoffDate)
                ->delete();

            $message = "Limpeza concluída. {$deletedCount} registros de failed_jobs com mais de {$retentionDays} dias foram deletados.";
            $this->info($message);

            return Command::SUCCESS;
        } catch (\Exception $e) {
            $errorMessage = "Erro ao limpar failed_jobs antigos: " . $e->getMessage();
            $this->error($errorMessage);
            return Command::FAILURE;
        }
    }
}