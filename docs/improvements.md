# Melhorias aplicadas no código

Este documento lista as melhorias aplicadas ao código ao longo do tempo, destacando as mudanças significativas que contribuíram para a otimização, legibilidade e manutenção do código.

## 1. Utilização de Docker para deploy e desenvolvimento
- Implementação de contêineres Docker para facilitar o ambiente de desenvolvimento e deploy.
- Configuração de Docker Compose para orquestração de múltiplos serviços.
- Redução de problemas de compatibilidade de ambiente.

## 2. Implementação de outras entidades além de "Films"
- Adição de suporte para entidades como "People", "Planets", "Species", "Starships" e "Vehicles".
- Criação de endpoints específicos para cada entidade, permitindo buscas e consultas detalhadas.
- Melhoria na estrutura do código para suportar múltiplas entidades de forma escalável.

## 3. Adição de pesquisa de entidades por propriedades
- Implementação de funcionalidades de busca para cada entidade, permitindo consultas por propriedades específicas.
- Criação de endpoints de pesquisa que aceitam parâmetros de consulta.
- Melhoria na experiência do usuário ao permitir buscas mais flexíveis e detalhadas.