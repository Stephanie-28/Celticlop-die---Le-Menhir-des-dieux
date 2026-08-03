```mermaid
erDiagram
    USER
    USER ||--o{ Favorite : possede
    USER ||--o{ QuizResult : recevoir
    Quiz ||--o{ Question : repondre
    Quiz ||--o{ QuizResult : acquerir
    Question ||--o{ Reponse : declarer
    Dieu }o--o{ Pantheons : avoir
    Dieu_Pantheons }o--o{ Pantheons : assujettir
    Dieu_Pantheons }o--o{ Dieu : lier
    Dieu }o--o{ Symbole : contenir
    Dieu }o--o{ Dieu_Symbole : allier
    Symbole }o--|| Dieu_Symbole : river
    Dieu }o--o{ Dieu_Animal : enchainer
    Animal }o--o{ Dieu_Animal : nouer
    Dieu }o--o{ Animal : compter
    Dieu }o--o{ Mythe : inclure
    Dieu }o--o{ Dieu_Mythe : ligoter
    Dieu ||--|| Music : Affilier
    Dieu }o--|| Reponse : associer
    Mythe }o--|| Chronique : attacher
    Mythe }o--|| Dieu_Mythe : amarrer
    Savoir

USER{
    Id int
    Pseudo string
    Email string
    Password string
    Role string
    Created_at datetime
}

Favorite{
    Id int
    USER_id int
    Entity_type enum
    Entity_id int
    Created_at datetime
}

QuizResult{
    Id int
    USER_id int
    Quiz_id int
    Dieu_id int
    Score int
    Created_at datetime
}

Reponse{
    Id int
    Question_id int
    Dieu_id int
    Reponse_text string
    Point int
}

Question{
    Id int
    Quiz_id int
    Question string
    order int
}

Quiz{
    Id int
    Title string
    Description string
    Created_at datetime
}

Dieu{
    Id int
    Name string
    Title string
    Description string
    Quote string
    Img string
}

Pantheons{
    Id int
    Title string
    Description string
}

Music{
    Id int
    Title string
    Artist string
    File_path string
}

Mythe{
    Id int
    Title string
    Content string
    Category enum
    Img string
    Created_at datetime
}

Symbole{
    Id int
    Name string
    Description string
    Img string
}

Animal{
    Id int
    Name string
    Description string
    Img string
}

Chronique{
    Id int
    Mythe_id int
    Title string
    Content string
    Img string
    Published_at datetime
}

Savoir{
    Id int
    Title string
    Content string
    Img string
    Is_focus boolean
    Created_at datetime
}

```
