import PromiseFtp, { ListingElement } from 'promise-ftp';
import fs from 'fs';
import filesConfig from '@config/filesConfig';
import AppError from '@shared/errors/AppError';
import IFtpProvider from '../models/IFtpProvider';

export default class FtpProvider implements IFtpProvider {
  public async syncFile(file: string): Promise<string> {
    const ftp = new PromiseFtp();
    const host = process.env.FTP_HOST;
    const user = process.env.FTP_USER;
    const password = process.env.FTP_PASSWORD;

    const filename = file.split('/').pop();

    if (typeof filename === 'string' && filename !== '') {
      return ftp
        .connect({ host, user, password })
        .then(() => {
          return ftp.get(file);
        })
        .then(
          stream =>
            new Promise((resolve, reject) => {
              stream.once('close', resolve);
              stream.once('error', reject);
              stream.pipe(
                fs.createWriteStream(
                  `${filesConfig.storageFolder}/${filename}`,
                ),
              );
            }),
        )
        .then(() => filename)
        .catch(err => err)
        .finally(() => ftp.end());
    }

    throw new AppError('filename not found');
  }

  public async getArrayFiles(): Promise<string[]> {
    const ftp = new PromiseFtp();
    const host = process.env.FTP_HOST;
    const user = process.env.FTP_USER;
    const password = process.env.FTP_PASSWORD;

    return ftp
      .connect({ host, user, password })
      .then(() => {
        return ftp.listSafe();
      })
      .then(list => {
        const arrayResults: string[] = [];

        list.forEach(folder => {
          const folderElement = folder as ListingElement;

          if (folderElement.name) {
            const isInvalidFolder =
              folderElement.name === '..' ||
              folderElement.name === '.' ||
              folderElement.name === '.ftpquota';

            if (isInvalidFolder) {
              return;
            }
          }

          ftp.list(folderElement.name).then(filesInFolder => {
            const filteredFilesInFolder = filesInFolder.filter(
              filteredFolder => {
                const filteringFolderElement = filteredFolder as ListingElement;

                return filteringFolderElement.type === '-';
              },
            );

            const mappedArrayFiles = filteredFilesInFolder.map(file => {
              const fileElement = file as ListingElement;

              return `${folderElement.name}/${fileElement.name}`;
            });

            arrayResults.push(...mappedArrayFiles);
          });
        });

        return arrayResults;
      })
      .catch(err => err)
      .finally(() => ftp.end());
  }
}
