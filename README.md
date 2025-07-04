# ระบบบันทึกผลการปฏิบัติงานประจำวัน

ระบบบันทึกผลการปฏิบัติงานประจำวัน พัฒนาด้วย PHP + Laravel และ MySQL

## คุณสมบัติของระบบ

- บันทึกรายการการปฏิบัติงานประจำวัน
- ค้นหาและแสดงรายการกิจกรรมตามวันที่
- รายงานผลการปฏิบัติงานประจำวัน
- รายงานสรุปจำนวนสถานะการทำงานรายเดือน
- ระบบสามารถเพิ่ม แก้ไข และลบข้อมูลกิจกรรมได้

## การติดตั้งและใช้งาน

### วิธีที่ 1: ใช้ Docker

1. ติดตั้ง Docker และ Docker Compose บนเครื่องของคุณ
2. Clone โปรเจคนี้
3. เปิด Terminal และเข้าไปที่โฟลเดอร์ของโปรเจค
4. รันคำสั่ง

```bash
docker-compose up -d
```

5. รอให้คอนเทนเนอร์ทั้งหมดเริ่มทำงาน
6. เข้าไปในคอนเทนเนอร์แอปพลิเคชัน

```bash
docker exec -it daily-activity-app bash
```

7. รันคำสั่งต่อไปนี้เพื่อติดตั้งและเตรียมแอปพลิเคชัน

```bash
composer install
php artisan key:generate
php artisan migrate --seed
```

8. เปิดเบราว์เซอร์และเข้าไปที่ http://localhost

### วิธีที่ 2: ติดตั้งแบบทั่วไป

1. ติดตั้ง PHP 8.1 หรือสูงกว่า
2. ติดตั้ง Composer
3. ติดตั้ง MySQL
4. Clone โปรเจคนี้
5. เปิด Terminal และเข้าไปที่โฟลเดอร์ของโปรเจค
6. รันคำสั่ง

```bash
composer install
cp .env.example .env
```

7. แก้ไขไฟล์ .env ให้ตรงกับการตั้งค่าฐานข้อมูลของคุณ
8. รันคำสั่ง

```bash
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

9. เปิดเบราว์เซอร์และเข้าไปที่ http://localhost:8000

## เทคโนโลยีที่ใช้

- PHP 8.1
- Laravel 10
- MySQL 5.7
- Bootstrap 5
- Font Awesome 6

## โครงสร้างของระบบ

- บันทึกกิจกรรมการปฏิบัติงานประจำวัน โดยแบ่งเป็น 3 ประเภทงาน: Development, Test, Document
- สถานะการทำงาน: กำลังดำเนินการ, เสร็จสิ้น, ยกเลิก
- มีการเก็บข้อมูลเวลาเริ่มต้น และเวลาสิ้นสุดของแต่ละกิจกรรม
- มีระบบรายงานสรุปผลการปฏิบัติงานรายวันและรายเดือน
