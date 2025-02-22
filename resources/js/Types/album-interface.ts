import { AlbumAccessCodeInterface } from '@/Types/album-access-code-interface';

export interface UserAlbumInterface {
  uuid: string;
  title: string;
  images: string[];
  description: string;
  eventDate: string;
}

export interface AdminAlbumInterface extends UserAlbumInterface {
  id: number;
  accessCodes: AlbumAccessCodeInterface[];
  qrCode: string;
}
