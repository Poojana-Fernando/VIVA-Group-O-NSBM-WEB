<?php
/**
 * MongoDB Auto-Increment Helper
 * Mimics MySQL's AUTO_INCREMENT using a 'counters' collection.
 */
function getNextSequence($db, $name) {
    $result = $db->counters->findOneAndUpdate(
        ['_id' => $name],
        ['$inc' => ['seq' => 1]],
        [
            'upsert' => true,
            'returnDocument' => MongoDB\Operation\FindOneAndUpdate::RETURN_DOCUMENT_AFTER
        ]
    );
    return $result['seq'];
}
?>
