export interface SettingsMap {
  mushola_name: string;
  tagline: string;
  history: string;
  vision: string;
  mission: string;
  facilities: string;
  address: string;
  phone_1: string;
  phone_2: string;
  email: string;
  maps_url: string;
  maps_embed: string;
  dkm_lead: string;
  dkm_treasurer: string;
  dkm_secretary: string;
  donation_active: string;
  donation_bank: string;
  donation_account: string;
  donation_holder: string;
  [key: string]: string;
}

export const defaultSettings: SettingsMap = {
  mushola_name: "Musholla Ar-rahman",
  tagline: "Pusat Ibadah, Kebersamaan, dan Pembinaan Umat di Lingkungan Gembor Periuk Tangerang",
  history: "Musholla Ar-rahman berdiri sejak tahun 1990 dengan gotong royong warga sekitar dan dibantu oleh pemerintah setempat untuk kegiatan beribadah lingkungan sekitarnya sehingga warga masyarakat semakin taat dan semangat dalam melakukan beribadah.",
  vision: "Terwujudnya Musholla Ar-rahman sebagai pusat ibadah yang makmur, mempererat ukhuwah islamiyah, dan melahirkan generasi Qur'ani yang berakhlak mulia.",
  mission: "1. Menyelenggarakan sholat berjamaah lima waktu secara istiqomah.\n2. Mengadakan kajian keislaman dan yasinan rutin untuk mempererat silaturahmi warga.\n3. Mengelola sarana dan prasarana ibadah yang bersih, nyaman, dan ramah jamaah.\n4. Membina anak-anak dan generasi muda dalam membaca Al-Qur'an.\n5. Menjaga transparansi dan amanah dalam pengelolaan kas musholla.",
  facilities: "Tempat Wudhu Pria & Wanita Terpisah, Sound System Berkualitas, Perpustakaan Mini & Al-Qur'an Wakaf, Area Parkir Motor, Karpet Sholat Nyaman, Gudang Perlengkapan, Toilet Bersih",
  address: "Jl. Anyer RT 007 RW 07, Kelurahan Gembor, Kecamatan Periuk, Kota Tangerang, Banten 15133",
  phone_1: "0813-8619-8079",
  phone_2: "0812-9465-6075",
  email: "dkm.musholla.arrahman@gmail.com",
  maps_url: "https://maps.app.goo.gl/JZzSrDEKjCseGwgw7?g_st=aw",
  maps_embed: "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15866.505295982056!2d106.577239!3d-6.180424!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f8c6543b5935%3A0x6b4847e9545dc6a9!2sGembor%2C%20Periuk%2C%20Tangerang%20City%2C%20Banten!5e0!3m2!1sen!2sid!4v1700000000000!5m2!1sen!2sid",
  dkm_lead: "USTADZ TATA A.S",
  dkm_treasurer: "Bapak Suwadi",
  dkm_secretary: "Bapak Bakri",
  donation_active: "1",
  donation_bank: "Bank BJB",
  donation_account: "0152632533100",
  donation_holder: "Musholla Ar-rahman",
};

export interface Post {
  id: number;
  title: string;
  slug: string;
  category: string;
  excerpt: string | null;
  content: string;
  image: string | null;
  author: string;
  status: string;
  views: number;
  created_at: string;
  updated_at: string;
}

export interface EventItem {
  id: number;
  title: string;
  slug: string;
  description: string;
  image: string | null;
  event_date: string;
  start_time: string;
  end_time: string;
  location: string;
  category: string;
  status: string;
  created_at: string;
}

export interface GalleryItem {
  id: number;
  title: string;
  image: string;
  category: string;
  description: string | null;
  created_at: string;
}

export interface FinanceReport {
  id: number;
  period_month: number;
  period_year: number;
  income: number;
  expense: number;
  balance: number;
  description: string;
  status: string;
  created_at: string;
  updated_at: string;
}

export interface ContactMessage {
  id: number;
  name: string;
  email: string | null;
  phone: string;
  subject: string;
  message: string;
  is_read: number;
  created_at: string;
}
