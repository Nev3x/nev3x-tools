def levenshtein_distance(str1, str2):
    len_str1 = len(str1) + 1
    len_str2 = len(str2) + 1
    matrix = [[0 for n in range(len_str2)] for m in range(len_str1)]
    
    for i in range(len_str1):
        matrix[i][0] = i
    for j in range(len_str2):
        matrix[0][j] = j

    for i in range(1, len_str1):
        for j in range(1, len_str2):
            if str1[i-1] == str2[j-1]:
                cost = 0
            else:
                cost = 1
            matrix[i][j] = min(matrix[i-1][j] + 1,       
                               matrix[i][j-1] + 1,       
                               matrix[i-1][j-1] + cost)  

    return matrix[-1][-1]

def similarity_ratio(str1, str2):
    distance = levenshtein_distance(str1, str2)
    max_len = max(len(str1), len(str2))
    similarity = 1 - (distance / max_len)
    return similarity


similarity = similarity_ratio(doc1, doc2)
print(f"Podobieństwo między dokumentami: {similarity:.2f}")
