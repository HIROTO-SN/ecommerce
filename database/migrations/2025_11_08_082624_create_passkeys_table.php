<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('passkeys', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                  ->constrained()
                  ->cascadeOnDelete(); // ユーザー削除時にパスキーも削除
            $table->string('credential_id')->unique(); // WebAuthn Credential ID
            $table->text('public_key');                 // 公開鍵（base64url形式など）
            $table->unsignedBigInteger('counter')->default(0); // 認証カウンタ
            $table->json('transports')->nullable();     // ["usb", "ble", "internal"] など
            $table->string('device_name')->nullable();  // 例: "iPhone 15 Pro"
            $table->timestamp('last_used_at')->nullable(); // 最終使用日時
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('passkeys');
    }
};